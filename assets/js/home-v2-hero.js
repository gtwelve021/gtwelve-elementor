(function () {
	'use strict';

	function escapeHtml(value) {
		return String(value || '')
			.replace(/&/g, '&amp;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;')
			.replace(/"/g, '&quot;')
			.replace(/'/g, '&#039;');
	}

	function decodeEntities(value) {
		var textarea = document.createElement('textarea');
		textarea.innerHTML = String(value || '');
		return textarea.value;
	}

	function formatAnswer(raw) {
		var text = decodeEntities(raw)
			.replace(/<br\s*\/?\s*>/gi, '\n')
			.replace(/\r/g, '')
			.replace(/<[^>]*>/g, '');
		var lines = text.split('\n').map(function (line) { return line.trim(); }).filter(Boolean);
		var html = [];
		var list = [];

		function inline(value) {
			return escapeHtml(value).replace(/\*\*(.+?)\*\*/g, '<strong>$1</strong>');
		}

		function flushList() {
			if (list.length) {
				html.push('<ul>' + list.join('') + '</ul>');
				list = [];
			}
		}

		lines.forEach(function (line) {
			var heading = line.match(/^#{2,6}\s+(.+)/);
			var bullet = line.match(/^(?:[-*•–]|\d+\.)\s+(.+)/);
			if (heading) {
				flushList();
				html.push('<h4>' + inline(heading[1]) + '</h4>');
			} else if (bullet) {
				list.push('<li>' + inline(bullet[1]) + '</li>');
			} else {
				flushList();
				html.push('<p>' + inline(line) + '</p>');
			}
		});
		flushList();

		return html.join('') || '<p></p>';
	}

	function initWidget(widget) {
		if (!widget || widget.dataset.g12HomeV2Ready === 'true') {
			return;
		}

		var forms = Array.prototype.slice.call(widget.querySelectorAll('[data-g12-home-v2-form]'));
		var inputs = Array.prototype.slice.call(widget.querySelectorAll('[data-g12-home-v2-input]'));
		var introItems = Array.prototype.slice.call(widget.querySelectorAll('[data-g12-home-v2-intro]'));
		var result = widget.querySelector('[data-g12-home-v2-results]');
		var answer = widget.querySelector('[data-g12-home-v2-answer]');
		var listenButton = widget.querySelector('[data-g12-home-v2-listen]');
		var summaryButton = widget.querySelector('[data-g12-home-v2-summary]');
		var ajaxUrl = widget.dataset.ajaxUrl || '';
		var action = widget.dataset.action || 'dubai_ai_home_v2';
		var normalText = widget.dataset.buttonText || 'Get Answer';
		var loadingText = widget.dataset.loadingText || 'Thinking...';
		var emptyMessage = widget.dataset.emptyMessage || 'Please type a question first.';
		var errorMessage = widget.dataset.errorMessage || 'We could not get an answer. Please try again.';
		var basePlaceholder = inputs[0] ? inputs[0].getAttribute('placeholder') || '' : '';
		var typingHints = [];
		var typingSpeed = Math.max(30, Math.min(200, parseInt(widget.dataset.typingSpeed || '72', 10)));
		var typingPause = Math.max(500, Math.min(5000, parseInt(widget.dataset.typingPause || '1500', 10)));
		var autoScroll = widget.dataset.autoScroll !== 'no';
		var scrollOffset = Math.max(0, Math.min(300, parseInt(widget.dataset.scrollOffset || '90', 10)));
		var latestAnswer = '';
		var history = [];
		var typingTimer = null;
		var hintIndex = 0;
		var characterIndex = 0;
		var isErasing = false;
		var audioPlayer = null;
		var audioGeneration = 0;
		var questionGeneration = 0;
		async function postAction(actionName, values) {
			var body = new URLSearchParams(values);
			body.set('action', actionName);
			var response = await window.fetch(ajaxUrl, { method: 'POST', body: body });
			var data = await response.json();
			if (!response.ok || data.error || data.success === false) { throw new Error(data.error || errorMessage); }
			return data.data || data;
		}
		function stopAudio() {
			audioGeneration++;
			if (audioPlayer) { audioPlayer.pause(); audioPlayer.removeAttribute('src'); audioPlayer = null; }
			if (listenButton) { listenButton.textContent = '◉ Listen'; listenButton.disabled = !latestAnswer; }
		}
		var callbackDialog = widget.querySelector('dialog');
		var callbackOpener;
		widget.querySelectorAll('[data-g12-callback-open]').forEach(function (button) {
			button.addEventListener('click', function (event) {
				event.preventDefault(); callbackOpener = button; callbackDialog.showModal();
			});
		});
		if (callbackDialog) {
			callbackDialog.querySelector('[data-callback-close]').addEventListener('click', function () { callbackDialog.close(); });
			callbackDialog.addEventListener('close', function () { if (callbackOpener) { callbackOpener.focus({ preventScroll: true }); } });
			callbackDialog.addEventListener('click', function (event) { if (event.target === callbackDialog) { var box = callbackDialog.getBoundingClientRect(); if (event.clientX < box.left || event.clientX > box.right || event.clientY < box.top || event.clientY > box.bottom) { callbackDialog.close(); } } });
			var callbackForm = callbackDialog.querySelector('[data-callback-form]');
			if (callbackForm) { callbackForm.addEventListener('submit', async function (event) {
				event.preventDefault();
				var button = callbackForm.querySelector('[type=submit]');
				var status = callbackForm.querySelector('[data-callback-status]');
				button.disabled = true; status.textContent = 'Sending…';
				var body = new URLSearchParams(new FormData(callbackForm));
				body.set('nonce', widget.dataset.callbackNonce || '');
				try { var data = await postAction('gtwelve_hero_callback', body); status.textContent = data.message; callbackForm.reset(); }
				catch (error) { status.textContent = error.message; }
				finally { button.disabled = false; }
			}); }
		}
		var resultsTransitionTimer = null;

		try {
			typingHints = JSON.parse(widget.getAttribute('data-typing-hints') || '[]');
		} catch (error) {
			typingHints = [];
		}
		typingHints = Array.isArray(typingHints) ? typingHints.map(function (hint) {
			return String(hint || '').trim();
		}).filter(Boolean) : [];
		if (!typingHints.length && basePlaceholder) {
			typingHints = [basePlaceholder];
		}

		widget.dataset.g12HomeV2Ready = 'true';
		window.requestAnimationFrame(function () {
			window.requestAnimationFrame(function () {
				widget.classList.add('is-motion-ready');
			});
		});

		try {
			history = JSON.parse(window.sessionStorage.getItem('g12_home_v2_widget_history') || '[]');
			if (!Array.isArray(history)) {
				history = [];
			}
		} catch (error) {
			history = [];
		}

		function syncInputs(value) {
			inputs.forEach(function (input) {
				input.value = value;
			});
		}

		function setPlaceholders(value) {
			inputs.forEach(function (input) {
				if (!input.value) {
					input.setAttribute('placeholder', value);
				}
			});
		}

		function hasInputValue() {
			return inputs.some(function (input) {
				return Boolean(input.value && input.value.trim());
			});
		}

		function hasFocusedInput() {
			return inputs.some(function (input) {
				return input === document.activeElement;
			});
		}

		function stopTyping(restorePlaceholder) {
			if (typingTimer) {
				window.clearTimeout(typingTimer);
				typingTimer = null;
			}
			if (restorePlaceholder) {
				setPlaceholders(basePlaceholder);
			}
		}

		function scheduleTyping(delay) {
			stopTyping(false);
			typingTimer = window.setTimeout(typePlaceholder, delay);
		}

		function typePlaceholder() {
			var phrase;
			if (!typingHints.length || hasInputValue()) {
				stopTyping(false);
				return;
			}
			if (hasFocusedInput()) {
				scheduleTyping(500);
				return;
			}

			phrase = typingHints[hintIndex] || basePlaceholder;
			if (!isErasing) {
				characterIndex = Math.min(phrase.length, characterIndex + 1);
				setPlaceholders(phrase.slice(0, characterIndex));
				if (characterIndex >= phrase.length) {
					isErasing = true;
					scheduleTyping(typingPause);
				} else {
					scheduleTyping(typingSpeed);
				}
			} else {
				characterIndex = Math.max(0, characterIndex - 1);
				setPlaceholders(phrase.slice(0, characterIndex));
				if (characterIndex === 0) {
					isErasing = false;
					hintIndex = (hintIndex + 1) % typingHints.length;
					scheduleTyping(420);
				} else {
					scheduleTyping(Math.max(25, Math.round(typingSpeed * 0.55)));
				}
			}
		}

		function startTyping(delay) {
			if (!typingHints.length || hasInputValue() || hasFocusedInput()) {
				return;
			}
			isErasing = false;
			characterIndex = 0;
			setPlaceholders('');
			scheduleTyping(typeof delay === 'number' ? delay : 700);
		}

		function prefersReducedMotion() {
			return Boolean(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches);
		}

		function getDocumentTop(element) {
			var top = 0;
			while (element) {
				top += element.offsetTop || 0;
				element = element.offsetParent;
			}
			return top;
		}

		function scrollToResults() {
			var top;
			if (!autoScroll || !result) {
				return;
			}
			top = getDocumentTop(result) - scrollOffset;
			window.scrollTo({
				top: Math.max(0, top),
				behavior: prefersReducedMotion() ? 'auto' : 'smooth'
			});
		}

		function revealResults() {
			introItems.forEach(function (item) {
				item.hidden = true;
				item.classList.remove('is-hiding');
			});
			if (result) {
				result.hidden = false;
			}
			widget.classList.remove('is-transitioning');
			widget.classList.add('is-results');
			window.requestAnimationFrame(function () {
				window.setTimeout(scrollToResults, prefersReducedMotion() ? 0 : 70);
			});
		}

		function showResults() {
			if (widget.classList.contains('is-results')) {
				if (result) {
					result.hidden = false;
				}
				scrollToResults();
				return;
			}
			if (widget.classList.contains('is-transitioning')) {
				return;
			}

			stopTyping(false);
			widget.classList.add('is-transitioning');
			introItems.forEach(function (item) {
				item.classList.add('is-hiding');
				item.setAttribute('aria-hidden', 'true');
			});

			if (resultsTransitionTimer) {
				window.clearTimeout(resultsTransitionTimer);
			}
			resultsTransitionTimer = window.setTimeout(revealResults, prefersReducedMotion() ? 20 : 540);
		}

		function setLoading(isLoading) {
			if (isLoading) {
				stopTyping(false);
			}
			widget.classList.toggle('is-loading', isLoading);
			if (answer) {
				answer.setAttribute('aria-busy', isLoading ? 'true' : 'false');
			}
			widget.querySelectorAll('[data-g12-home-v2-submit]').forEach(function (button) {
				button.disabled = isLoading;
				var label = button.querySelector('[data-g12-home-v2-button-label]');
				if (label) {
					label.textContent = isLoading ? loadingText : normalText;
				}
			});
		}

		function setAnswer(html, isError) {
			if (!answer) {
				return;
			}
			answer.innerHTML = html;
			answer.classList.toggle('is-error', Boolean(isError));
		}

		function saveHistory(question, responseText) {
			history.push({ role: 'user', content: question });
			history.push({ role: 'assistant', content: responseText.replace(/<[^>]*>/g, ' ') });
			history = history.slice(-6);
			try {
				window.sessionStorage.setItem('g12_home_v2_widget_history', JSON.stringify(history));
			} catch (error) {
				// Storage can be disabled; the current answer still works.
			}
		}

		async function requestAnswer(question, mode) {
			var body = new URLSearchParams();
			var response;
			var data;

			body.append('action', action);
			body.append('question', question);
			if (mode) {
				body.append('mode', mode);
			}
			if (mode === 'summary') {
				body.append('answer', latestAnswer.replace(/<[^>]*>/g, ' '));
			} else {
				body.append('history', JSON.stringify(history.slice(-6)));
			}

			response = await window.fetch(ajaxUrl, {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
				body: body.toString()
			});

			if (!response.ok) {
				throw new Error('HTTP ' + response.status);
			}

			data = await response.json();
			if (data && data.success && data.data) {
				data = data.data;
			}
			if (!data || (!data.answer && data.error)) {
				throw new Error(data && data.error ? data.error : 'Invalid response');
			}

			return data.answer || '';
		}

		async function ask(question) {
			question = String(question || '').trim();
			if (widget.classList.contains('is-loading')) { return; }
			stopAudio();
			var generation = ++questionGeneration;
			showResults();
			if (!question) {
				setAnswer('<p class="g12-home-v2-widget__status">' + escapeHtml(emptyMessage) + '</p>', true);
				return;
			}

			syncInputs(question);
			setLoading(true);
			setAnswer('<p class="g12-home-v2-widget__status">' + escapeHtml(loadingText) + '</p>', false);

			try {
				latestAnswer = await requestAnswer(question, '');
				postAction('gtwelve_hero_related', { q: question }).then(function (data) {
					var related = widget.querySelector('.g12-home-v2-widget__related');
					if (!related || generation !== questionGeneration || !Array.isArray(data.links) || !data.links.length) { return; }
					var links = data.links.filter(function (link) { try { return /^https?:$/.test(new URL(link.url, location.href).protocol); } catch (error) { return false; } });
					if (!links.length) { return; }
					related.replaceChildren();
					links.forEach(function (link) { var a = document.createElement('a'); a.href = link.url; a.textContent = decodeEntities(link.title); related.appendChild(a); });
				}).catch(function () { /* Keep the Elementor fallback links. */ });
				setAnswer(formatAnswer(latestAnswer), false);
				saveHistory(question, latestAnswer);
				if (listenButton) {
					listenButton.disabled = false;
				}
				if (summaryButton) {
					summaryButton.disabled = false;
				}
			} catch (error) {
				setAnswer('<p class="g12-home-v2-widget__status">' + escapeHtml(errorMessage) + '</p>', true);
			} finally {
				setLoading(false);
			}
		}

		forms.forEach(function (form) {
			form.addEventListener('submit', function (event) {
				event.preventDefault();
				var input = form.querySelector('[data-g12-home-v2-input]');
				ask(input ? input.value : '');
			});
		});

		inputs.forEach(function (input) {
			input.addEventListener('focus', function () {
				stopTyping(true);
			});
			input.addEventListener('input', function () {
				syncInputs(input.value);
				if (input.value) {
					stopTyping(false);
				}
			});
			input.addEventListener('blur', function () {
				if (!hasInputValue()) {
					startTyping(650);
				}
			});
		});

		if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			setPlaceholders(basePlaceholder);
		} else {
			startTyping(850);
		}

		widget.querySelectorAll('[data-g12-home-v2-query]').forEach(function (button) {
			button.addEventListener('click', function () {
				ask(button.dataset.g12HomeV2Query || button.textContent);
			});
		});

		widget.querySelectorAll('[data-g12-home-v2-voice]').forEach(function (voiceButton) {
			voiceButton.addEventListener('click', function () {
				var Recognition = window.SpeechRecognition || window.webkitSpeechRecognition;
				var recognition;
				if (!Recognition) {
					setAnswer('<p class="g12-home-v2-widget__status">Voice search is not supported in this browser.</p>', true);
					showResults();
					return;
				}
				recognition = new Recognition();
				recognition.lang = document.documentElement.lang || 'en-US';
				recognition.interimResults = false;
				voiceButton.classList.add('is-listening');
				recognition.onresult = function (event) {
					var transcript = event.results[0][0].transcript || '';
					syncInputs(transcript);
					ask(transcript);
				};
				recognition.onend = function () {
					voiceButton.classList.remove('is-listening');
				};
				recognition.onerror = recognition.onend;
				recognition.start();
			});
		});

		if (listenButton) {
			listenButton.addEventListener('click', async function () {
				if (!latestAnswer) { return; }
				if (audioPlayer) { stopAudio(); return; }
				var generation = ++audioGeneration;
				listenButton.disabled = true; listenButton.textContent = 'Preparing audio…';
				try {
					var data = await postAction(action, { mode: 'tts', text: answer.textContent });
					if (generation !== audioGeneration) { return; }
					if (!data.audio) { throw new Error('No audio'); }
					audioPlayer = new Audio('data:audio/mpeg;base64,' + data.audio);
					audioPlayer.onended = stopAudio;
					audioPlayer.onerror = stopAudio;
					await audioPlayer.play(); listenButton.textContent = '■ Stop';
				} catch (error) { if (generation === audioGeneration) { stopAudio(); listenButton.textContent = 'Audio unavailable — retry'; } }
				finally { if (generation === audioGeneration) { listenButton.disabled = false; } }
			});
		}

		if (summaryButton) {
			summaryButton.addEventListener('click', async function () {
				if (!latestAnswer) {
					return;
				}
				summaryButton.disabled = true;
				stopAudio();
				try {
					latestAnswer = await requestAnswer('', 'summary');
					setAnswer(formatAnswer(latestAnswer), false);
				} catch (error) {
					setAnswer('<p class="g12-home-v2-widget__status">' + escapeHtml(errorMessage) + '</p>', true);
				} finally {
					summaryButton.disabled = false;
				}
			});
		}
		var prefill = new URLSearchParams(window.location.search).get('s');
		if (prefill) { syncInputs(prefill); ask(prefill); }
	}

	function init(scope) {
		var root = scope && scope.querySelectorAll ? scope : document;
		root.querySelectorAll('[data-g12-home-v2]').forEach(initWidget);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () { init(document); });
	} else {
		init(document);
	}

	window.addEventListener('load', function () { init(document); });

	if (window.elementorFrontend && window.elementorFrontend.hooks && window.jQuery) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_home_v2_hero.default', function ($scope) {
			init($scope[0]);
		});
	}
}());
