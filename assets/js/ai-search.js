(function () {
	'use strict';

	function escapeAttribute(value) {
		return String(value)
			.replace(/&/g, '&amp;')
			.replace(/"/g, '&quot;')
			.replace(/</g, '&lt;')
			.replace(/>/g, '&gt;');
	}

	function convertMarkdownLinks(text) {
		if (!text) {
			return '';
		}

		return String(text).replace(/\[([^\]]+)\]\((https?:\/\/[^\s)]+)\)/g, function (match, label, url) {
			return '<a href="' + escapeAttribute(url) + '" target="_blank" rel="noopener">' + escapeAttribute(label) + '</a>';
		});
	}

	function showResponse(response, html) {
		response.innerHTML = html;
		response.hidden = false;
		response.classList.add('is-visible');
	}

	function hideResponse(response) {
		response.hidden = true;
		response.classList.remove('is-visible');
	}

	function setButtonLoading(button, isLoading, normalText, loadingText) {
		button.disabled = isLoading;
		button.textContent = isLoading ? loadingText : normalText;
	}

	function initWidget(widget) {
		var input = widget.querySelector('[data-g12-ai-search-input]');
		var button = widget.querySelector('[data-g12-ai-search-submit]');
		var response = widget.querySelector('[data-g12-ai-search-response]');
		var ajaxUrl = widget.getAttribute('data-ajax-url') || '';
		var action = widget.getAttribute('data-action') || 'dubai_ai_ask';
		var normalText = widget.getAttribute('data-button-text') || 'Ask';
		var loadingText = widget.getAttribute('data-thinking-text') || 'Thinking...';
		var emptyMessage = widget.getAttribute('data-empty-message') || 'Please enter a question.';
		var errorMessage = widget.getAttribute('data-error-message') || 'Error getting response.';
		var answerLabel = widget.getAttribute('data-answer-label') || 'Answer:';

		if (!input || !button || !response || widget.dataset.g12AiSearchReady === 'true') {
			return;
		}

		widget.dataset.g12AiSearchReady = 'true';

		async function askQuestion() {
			var question = input.value.trim();
			var body = new URLSearchParams();
			var data;
			var safeAnswer;

			if (!question) {
				showResponse(response, escapeAttribute(emptyMessage));
				return;
			}

			setButtonLoading(button, true, normalText, loadingText);
			showResponse(response, escapeAttribute(loadingText));

			body.append('action', action);
			body.append('question', question);

			try {
				data = await window.fetch(ajaxUrl, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					body: body.toString()
				}).then(function (requestResponse) {
					if (!requestResponse.ok) {
						throw new Error('HTTP ' + requestResponse.status);
					}
					return requestResponse.json();
				});
				if (!data || data.error || !data.answer) {
					throw new Error(data && data.error ? data.error : 'Invalid response');
				}

				safeAnswer = convertMarkdownLinks(data.answer);
				showResponse(response, '<strong>' + escapeAttribute(answerLabel) + '</strong><br><p>' + safeAnswer + '</p>');
			} catch (error) {
				showResponse(response, escapeAttribute(errorMessage));
			} finally {
				setButtonLoading(button, false, normalText, loadingText);
			}
		}

		button.addEventListener('click', askQuestion);

		input.addEventListener('keydown', function (event) {
			if (event.key === 'Enter') {
				event.preventDefault();
				askQuestion();
			}
		});

		document.addEventListener('click', function (event) {
			if (!widget.contains(event.target)) {
				hideResponse(response);
			}
		});
	}

	function init(scope) {
		var root = scope && scope.querySelectorAll ? scope : document;

		root.querySelectorAll('[data-g12-ai-search]').forEach(initWidget);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			init(document);
		});
	} else {
		init(document);
	}

	window.addEventListener('load', function () {
		init(document);
	});

	if (
		window.elementorFrontend &&
		window.elementorFrontend.hooks &&
		typeof window.elementorFrontend.hooks.addAction === 'function' &&
		window.jQuery
	) {
		window.elementorFrontend.hooks.addAction('frontend/element_ready/g12_ai_search.default', function ($scope) {
			init($scope[0]);
		});
	}
}());
