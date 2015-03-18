<?php
class kindeditor
{
	private $plugin_path;

	public function __construct() {
		$this->plugin_path = plugins_url('/',__FILE__);
	}

	public function deactivate() {
		global $current_user;
		update_user_option($current_user->ID, 'rich_editing', 'true', true);
	}

	public function activate() {
		global $current_user;
		update_user_option($current_user->ID, 'rich_editing', 'false', true);
	}

	public function load_kindeditor() {
		?>
		<script type="text/javascript">
		//<![CDATA[
			var editor;
			var options = {
                filterMode: false,
                cssPath : ['<?php echo $this->plugin_path; ?>style.css'],
				items : [
				'source', '|', 'undo', 'redo', '|', 'template', 'cut', 'copy', 'paste',
				'plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright',
				'justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript',
				'superscript', 'clearhtml', 'quickformat', 'selectall', '/',
				'formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold',
				'italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'table', 'hr', 'anchor', 'blockquote', 'wpmore',
				'link', 'unlink', '|', 'map', 'baidumap','fullscreen','about'
				],
				afterChange : function() {
					jQuery('#wp-word-count .word-count').html(this.count('text'));
				}
			};
			KindEditor.ready(function(K) {
				editor = K.create('#content',options);
			});
		//]]>
		</script>
		<?php
	}

	public function user_personalopts_update() {
        global $current_user;
        update_user_option($current_user->ID, 'rich_editing', 'false', true);
    }

	public function add_admin_js() {
		wp_deregister_script(array('media-upload'));
		wp_enqueue_script('media-upload', $this->plugin_path .'media-upload.js', array('thickbox'), '20110922');
		wp_enqueue_script('kindeditor', $this->plugin_path . 'kindeditor.js');
		wp_enqueue_script('zh_CN', $this->plugin_path . 'lang/zh_CN.js');
		wp_enqueue_script('plugins', $this->plugin_path . 'plugins.js');
	}

	public function add_admin_style() {
		$ke_style = plugins_url('themes/default/default.css', __FILE__);
		wp_register_style('default', $ke_style);
		wp_enqueue_style('default');
	}

	public function add_admin_head() {
		?>
		<style type="text/css">
			#ed_toolbar { display: none; }
			.ke-container {border: none;!important}
			.ke-icon-wpmore {
				background-image: url(<?php echo $this->plugin_path;?>themes/default/default.png);
				background-position: 0px -1024px;
				width: 16px;
				height: 16px;
			}
			.ke-icon-blockquote {
				background-image: url(<?php echo $this->plugin_path;?>themes/default/quote.gif);
				width: 16px;
				height: 16px;
			}
		</style>
		<?php
    }
}

$kindeditor = new kindeditor();