<?php
namespace GTwelveElementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin-owned public AJAX endpoints for the AI Search and Home V2 widgets.
 */
final class AI_Handler {
	private const SEARCH_ACTION = 'dubai_ai_ask';
	private const HERO_ACTION   = 'dubai_ai_home_v2';
	private const RATE_LIMIT    = 15;
	private const RATE_WINDOW   = 60;

	public static function register(): void {
		foreach ( array( 'related' => 'handle_related', 'callback' => 'handle_callback' ) as $action => $method ) {
			add_action( 'wp_ajax_gtwelve_hero_' . $action, array( __CLASS__, $method ) );
			add_action( 'wp_ajax_nopriv_gtwelve_hero_' . $action, array( __CLASS__, $method ) );
		}
		add_action( 'wp_ajax_' . self::SEARCH_ACTION, array( __CLASS__, 'handle_search' ), 1 );
		add_action( 'wp_ajax_nopriv_' . self::SEARCH_ACTION, array( __CLASS__, 'handle_search' ), 1 );
		add_action( 'wp_ajax_' . self::HERO_ACTION, array( __CLASS__, 'handle_hero' ), 1 );
		add_action( 'wp_ajax_nopriv_' . self::HERO_ACTION, array( __CLASS__, 'handle_hero' ), 1 );
	}

	public static function handle_search(): void {
		self::guard_request();
		$question = self::posted_text( 'question', 2000 );
		if ( '' === $question ) {
			self::send_error( __( 'Please enter a question.', 'gtwelve-elementor' ), 400 );
			return;
		}

		$prompt = "You are a Dubai business setup consultant working at G12.ae. Respond in a formal, professional tone using two to three structured paragraphs, about 80 words total. Be clear, informative, and confident. Mention G12.ae naturally as the trusted expert, but do not say 'visit our website'. Avoid numbered steps; instead, summarize helpful advice in paragraph form.";
		self::send_answer( self::chat( $question, $prompt, 0.3, 270 ) );
	}

	public static function handle_hero(): void {
		self::guard_request();
		$mode = self::posted_text( 'mode', 20 );
		if ( 'tts' === $mode ) {
			self::speech();
			return;
		}

		if ( 'summary' === $mode ) {
			$source = self::posted_text( 'answer', 3000 );
			if ( '' === $source ) {
				self::send_error( __( 'There is no answer to summarize.', 'gtwelve-elementor' ), 400 );
				return;
			}
			$prompt   = "You are a Dubai business setup consultant at G12.ae. Write a single concise formal paragraph (40-80 words) summarizing the provided content. Output plain text only: no bullets, no numbering, no markdown, no HTML. Be specific and practical. Do not say 'visit G12.ae'.";
			$question = "Summarize this for a business user in Dubai as one formal paragraph (plain text, 40-80 words):\n\n" . $source;
			self::send_answer( self::chat( $question, $prompt, 0.2, 140 ) );
			return;
		}

		$question = self::posted_text( 'question', 2000 );
		if ( '' === $question ) {
			self::send_error( __( 'Please enter a question.', 'gtwelve-elementor' ), 400 );
			return;
		}

		$prompt = "You are a Dubai business setup consultant at G12.ae. Keep answers clear and helpful for a G12 user. Use: 1) a direct answer; 2) one context paragraph; 3) two or three bullets with specifics; 4) a friendly next step. Write 200-360 practical words without buzzwords. You may use simple markdown headings, bullets, and bold labels. Mention G12.ae naturally, but do not use the word 'visit' or phrases such as 'visit G12.ae' or 'visit our website'.";
		self::send_answer( self::chat( $question, $prompt, 0.25, 650, self::posted_history() ) );
	}

	public static function handle_related(): void {
		self::guard_request();
		if ( '' === self::posted_text( 'q', 200 ) ) {
			wp_send_json( array( 'links' => array() ) );
			return;
		}
		$query = new \WP_Query( array( 's' => self::posted_text( 'q', 200 ), 'post_type' => 'post', 'post_status' => 'publish', 'has_password' => false, 'posts_per_page' => 3, 'no_found_rows' => true, 'orderby' => 'relevance' ) );
		$links = array();
		foreach ( $query->posts as $post ) {
			$links[] = array( 'title' => html_entity_decode( wp_strip_all_tags( get_the_title( $post ) ), ENT_QUOTES | ENT_HTML5, get_bloginfo( 'charset' ) ), 'url' => get_permalink( $post ) );
		}
		wp_send_json( array( 'links' => $links ) );
	}

	public static function handle_callback(): void {
		self::guard_request();
		if ( ! check_ajax_referer( 'gtwelve_hero_callback', 'nonce', false ) ) {
			self::send_error( 'Please refresh the page and try again.', 403 );
			return;
		}
		$name = self::posted_text( 'name', 100 );
		$phone = self::posted_text( 'phone', 40 );
		$email = self::posted_text( 'email', 254 );
		if ( '' === $name || ! preg_match( '/^[+()\d\s.-]{6,40}$/', $phone ) || ( '' !== $email && ! is_email( $email ) ) || '' !== self::posted_text( 'website', 100 ) ) {
			self::send_error( 'Please enter a valid name, phone number and email.', 400 );
			return;
		}
		$body = "Name: {$name}\nPhone: {$phone}\nEmail: {$email}\nNote: " . self::posted_text( 'note', 2000 );
		$sent = wp_mail( get_option( 'admin_email' ), '[G12] Callback request', $body, array( 'Content-Type: text/plain; charset=UTF-8' ) );
		if ( ! $sent ) {
			self::send_error( 'We could not send your request. Please try again or contact us by phone.', 502 );
			return;
		}
		wp_send_json( array( 'message' => 'Thank you. Your callback request has been sent.' ) );
	}

	private static function speech(): void {
		$text = self::posted_text( 'text', 4000 );
		$key = self::api_key();
		if ( '' === $text || '' === $key ) {
			self::send_error( 'Audio is unavailable. Please try again later.', 503 );
			return;
		}
		$model = defined( 'G12_OPENAI_TTS_MODEL' ) ? G12_OPENAI_TTS_MODEL : ( getenv( 'G12_OPENAI_TTS_MODEL' ) ?: 'gpt-4o-mini-tts' );
		$response = wp_remote_post( 'https://api.openai.com/v1/audio/speech', array(
			'headers' => array( 'Authorization' => 'Bearer ' . $key, 'Content-Type' => 'application/json' ),
			'body' => wp_json_encode( array( 'model' => $model, 'input' => $text, 'voice' => 'alloy', 'response_format' => 'mp3' ) ),
			'timeout' => 45,
		) );
		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) || '' === wp_remote_retrieve_body( $response ) || false !== stripos( (string) wp_remote_retrieve_header( $response, 'content-type' ), 'json' ) ) {
			self::send_error( 'Audio could not be generated. Please try again.', 502 );
			return;
		}
		wp_send_json( array( 'audio' => base64_encode( wp_remote_retrieve_body( $response ) ), 'format' => 'mp3' ) );
	}

	private static function chat( string $question, string $system_prompt, float $temperature, int $max_tokens, array $history = array() ): array {
		$api_key = self::api_key();
		if ( '' === $api_key ) {
			return array( 'error' => __( 'AI service is not configured. Please contact the site administrator.', 'gtwelve-elementor' ), 'status' => 503 );
		}

		$messages = array( array( 'role' => 'system', 'content' => $system_prompt ) );
		foreach ( array_slice( $history, -6 ) as $message ) {
			$messages[] = $message;
		}
		$messages[] = array( 'role' => 'user', 'content' => $question );

		$response = wp_remote_post(
			'https://api.openai.com/v1/chat/completions',
			array(
				'headers' => array(
					'Authorization' => 'Bearer ' . $api_key,
					'Content-Type'  => 'application/json',
				),
				'body'    => wp_json_encode(
					array(
						'model'       => self::model(),
						'messages'    => $messages,
						'temperature' => $temperature,
						'max_tokens'  => $max_tokens,
					)
				),
				'timeout' => 40,
			)
		);

		if ( is_wp_error( $response ) ) {
			return array( 'error' => __( 'The AI service is temporarily unavailable. Please try again.', 'gtwelve-elementor' ), 'status' => 502 );
		}

		$status = (int) wp_remote_retrieve_response_code( $response );
		$data   = json_decode( wp_remote_retrieve_body( $response ), true );
		$answer = is_array( $data ) ? (string) ( $data['choices'][0]['message']['content'] ?? '' ) : '';
		if ( $status < 200 || $status >= 300 || '' === trim( $answer ) ) {
			return array( 'error' => __( 'The AI service could not complete the request. Please try again.', 'gtwelve-elementor' ), 'status' => 502 );
		}

		return array( 'answer' => nl2br( esc_html( trim( $answer ) ) ) );
	}

	private static function api_key(): string {
		$key = (string) getenv( 'G12_OPENAI_API_KEY' );
		if ( defined( 'G12_OPENAI_API_KEY' ) && '' !== trim( (string) G12_OPENAI_API_KEY ) ) {
			$key = (string) G12_OPENAI_API_KEY;
		}
		if ( '' === trim( $key ) ) {
			$key = (string) getenv( 'OPENAI_API_KEY' );
			if ( defined( 'OPENAI_API_KEY' ) && '' !== trim( (string) OPENAI_API_KEY ) ) {
				$key = (string) OPENAI_API_KEY;
			}
		}
		return trim( $key );
	}

	private static function model(): string {
		$model = (string) getenv( 'G12_OPENAI_MODEL' );
		if ( defined( 'G12_OPENAI_MODEL' ) && '' !== trim( (string) G12_OPENAI_MODEL ) ) {
			$model = (string) G12_OPENAI_MODEL;
		}
		if ( '' === trim( $model ) ) {
			$model = 'gpt-4o-mini';
		}
		return (string) apply_filters( 'gtwelve_elementor_openai_model', trim( $model ) );
	}

	private static function posted_history(): array {
		$raw     = isset( $_POST['history'] ) ? wp_unslash( $_POST['history'] ) : '';
		$decoded = is_string( $raw ) ? json_decode( $raw, true ) : array();
		$history = array();
		if ( ! is_array( $decoded ) ) {
			return $history;
		}

		foreach ( array_slice( $decoded, -6 ) as $message ) {
			if ( ! is_array( $message ) ) {
				continue;
			}
			$role    = isset( $message['role'] ) && is_string( $message['role'] ) ? sanitize_key( $message['role'] ) : '';
			$content = isset( $message['content'] ) && is_string( $message['content'] ) ? sanitize_textarea_field( $message['content'] ) : '';
			if ( ! in_array( $role, array( 'user', 'assistant' ), true ) || '' === $content ) {
				continue;
			}
			$history[] = array( 'role' => $role, 'content' => self::limit_text( $content, 1500 ) );
		}
		return $history;
	}

	private static function posted_text( string $key, int $limit ): string {
		$value = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		$value = is_string( $value ) ? sanitize_textarea_field( $value ) : '';
		return trim( self::limit_text( $value, $limit ) );
	}

	private static function limit_text( string $value, int $limit ): string {
		return function_exists( 'mb_substr' ) ? mb_substr( $value, 0, $limit ) : substr( $value, 0, $limit );
	}

	private static function guard_request(): void {
		if ( 'POST' !== strtoupper( (string) ( $_SERVER['REQUEST_METHOD'] ?? '' ) ) ) {
			self::send_error( __( 'Invalid request method.', 'gtwelve-elementor' ), 405 );
		}

		$address = sanitize_text_field( (string) ( $_SERVER['REMOTE_ADDR'] ?? 'unknown' ) );
		$key     = 'g12_ai_rate_' . md5( $address );
		$count   = (int) get_transient( $key );
		if ( $count >= (int) apply_filters( 'gtwelve_elementor_ai_rate_limit', self::RATE_LIMIT ) ) {
			self::send_error( __( 'Too many requests. Please wait a moment and try again.', 'gtwelve-elementor' ), 429 );
		}
		set_transient( $key, $count + 1, self::RATE_WINDOW );
	}

	private static function send_answer( array $result ): void {
		if ( isset( $result['error'] ) ) {
			self::send_error( (string) $result['error'], (int) ( $result['status'] ?? 500 ) );
			return;
		}
		wp_send_json( array( 'answer' => (string) ( $result['answer'] ?? '' ) ) );
	}

	private static function send_error( string $message, int $status ): void {
		wp_send_json( array( 'error' => $message ), $status );
	}
}
