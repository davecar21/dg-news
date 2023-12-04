<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    dg_news
 * @subpackage dg_news/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    dg_news
 * @subpackage dg_news/public
 * @author     Your Name <email@example.com>
 */
class dg_news_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $dg_news    The ID of this plugin.
	 */
	private $dg_news;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $dg_news       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	private $news_data;
	public function __construct( $dg_news, $version ) {

		$this->dg_news = $dg_news;
		$this->version = $version;

		add_shortcode('news_shortcode', array($this, 'news_shortcode_function'));
		add_shortcode('news_list_shortcode', array($this, 'news_list_shortcode_function'));
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in dg_news_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The dg_news_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->dg_news, plugin_dir_url( __FILE__ ) . 'css/dg-news-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'dg-news-list-public', plugin_dir_url( __FILE__ ) . 'css/dg-news-list-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in dg_news_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The dg_news_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->dg_news, plugin_dir_url( __FILE__ ) . 'js/dg-news-public.js', array( 'jquery' ), $this->version, false );

	}

	public function fetch_news_comics($pageSize = 6) {
		// Set the API endpoint URL
		$api_url = 'https://newsapi.org/v2/everything?q=Japan&pageSize='.$pageSize.'&apiKey=e49c48fdc0fc4a5c9dbc051af3f3ab1a';

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_USERAGENT, 'news-hp'); 

		$response = curl_exec($ch);

		if (curl_errno($ch)) {
			die('Error fetching data: ' . curl_error($ch));
		}

		curl_close($ch);
		$data = json_decode($response, true);
		if ($data === null) {
			die('Error decoding JSON data from the API.');
		}
		
		$this->news_data = $data;
		return $data;
	}


	public function news_shortcode_function($atts) {
		$this->fetch_news_comics(6);
		ob_start();

		include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/dg-news-public-display.php';

		$output = ob_get_clean();

		return $output;
	}

	public function news_list_shortcode_function($atts) {
		$this->fetch_news_comics(3);
		ob_start();

		include plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/dg-news-list-public-display.php';

		$output = ob_get_clean();

		return $output;
	}
}
