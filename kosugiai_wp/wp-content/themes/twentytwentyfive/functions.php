<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */


function remove_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('updates');
	$wp_admin_bar->remove_menu('new-content');
	$wp_admin_bar->remove_menu('comments');
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action('admin_bar_menu', 'remove_admin_bar', 999);

function login_redirect($redirect_to, $request, $user) {
	if(isset($user->roles) && is_array($user->roles)) {
		return admin_url('edit.php?post_type=games');
	} else {
		return $redirect_to;
	}
}
add_filter( 'login_redirect', 'login_redirect', 10, 3 );

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues the theme stylesheet on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues the theme stylesheet on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		$suffix = SCRIPT_DEBUG ? '' : '.min';
		$src    = 'style' . $suffix . '.css';

		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( $src ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
		wp_style_add_data(
			'twentytwentyfive-style',
			'path',
			get_parent_theme_file_path( $src )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ($post_format_slug && 'standard' !== $post_format_slug) {
			return get_post_format_string($post_format_slug);
		}
	}
endif;

/**
 * 試合情報管理サイドバーウィジェットの追加
 * @return void
 */
function add_games_sidebar_widget() {
	$screen = get_current_screen();
	if ($screen && $screen->id === 'edit-games') {
		add_action('admin_footer', 'games_info_widget_display');
	}
}
add_action('current_screen', 'add_games_sidebar_widget');

/**
 * 試合情報管理の表示
 * @return void
 */
function games_info_widget_display() {
	?>
	<script>
	jQuery(document).ready(function($) {
		var widget = `
		<p>以下のリンクから試合情報を管理できます。</p>
		
		<div>
			<div class="postbox">
				<div class="inside">
					<div>
						<h3>J1試合結果</h3>
						<p>J1試合結果に関する情報を管理します</p>
						<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=j1_games' ) ); ?>" 
						   class="button button-primary button-large">J1試合結果</a>
					</div>
				</div>
			</div>
		</div>

		<div>
			<div class="postbox">
				<div class="inside">
					<div>
						<h3 style="margin-top: 20px;">ルヴァンカップ試合結果</h3>
						<p>ルヴァンカップ試合結果に関する情報を管理します</p>
						<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=levain_games' ) ); ?>" 
						   class="button button-primary button-large">ルヴァンカップ試合結果</a>
					</div>
				</div>
			</div>
		</div>

		<div>
			<div class="postbox">
				<div class="inside">
					<div>
						<h3 style="margin-top: 20px;">その他の試合結果</h3>
						<p>その他の試合結果に関する情報を管理します</p>
						<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=other_games' ) ); ?>" 
						   class="button button-primary button-large">その他の試合結果</a>
					</div>
				</div>
			</div>
		</div>
		`;
		
		$('.wp-header-end').after(widget);
	
		$('.page-title-action').remove();
		$('.subsubsub').remove();
		$('.search-box').remove();
		$('.tablenav').remove();
		$('.wp-list-table').remove();
		$('.view-switch').remove();
		$('#posts-filter .actions').remove();
		$('#screen-options-link-wrap').remove();
	});
	</script>
	<?php
}

// J1試合結果にカスタムカラムを追加
function j1_games_columns($columns) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['game_name'] = '試合名';
	$new_columns['opponent_club'] = '対戦相手';
	$new_columns['game_datetime'] = '試合日時';
	$new_columns['post_status'] = '公開状態';
	$new_columns['open_datetime'] = '公開開始日時';
	$new_columns['close_datetime'] = '公開終了日時';
	$new_columns['actions'] = '編集';
	return $new_columns;
}
add_filter('manage_j1_games_posts_columns', 'j1_games_columns');

// J1試合結果に値を表示
function j1_games_custom_column($column, $post_id) {
	switch ($column) {
		case 'game_name':
			$game_name = get_field('game_name', $post_id);
			$edit_link = get_edit_post_link($post_id);
			if ($game_name && $edit_link) {
				echo '<a href="' . esc_url($edit_link) . '">' . esc_html($game_name) . '</a>';
			} else {
				echo '—';
			}
			break;
		case 'opponent_club':
			$opponent_club_id = get_field('opponent_club', $post_id);
			if ($opponent_club_id) {	
				$club_name = get_field('opponent_club', $opponent_club_id);
				echo $club_name ? esc_html($club_name) : '—';
			} else {
				echo '—';
			}
			break;	
		case 'game_datetime':
			$game_datetime = get_field('game_datetime', $post_id);
			if ($game_datetime) {
				echo esc_html(date('Y時m月d日 H時i分', strtotime($game_datetime)));
			} else {
				echo '—';
			}
			break;
		case 'post_status':
			$status = get_post_status($post_id);
			$status_labels = array(
				'publish' => '公開済み',
				'draft' => '下書き',
				'pending' => 'レビュー待ち',
				'private' => '非公開',
			);
			echo isset($status_labels[$status]) ? esc_html($status_labels[$status]) : esc_html($status);
			break;
		case 'open_datetime':
			$open_datetime = get_field('open_datetime', $post_id);
			if ($open_datetime) {
				echo esc_html(date('Y時m月d日 H時i分', strtotime($open_datetime)));
			} else {
				echo '—';
			}
			break;
		case 'close_datetime':
			$close_datetime = get_field('close_datetime', $post_id);
			if ($close_datetime) {
				echo esc_html(date('Y時m月d日 H時i分', strtotime($close_datetime)));
			} else {
				echo '—';
			}
			break;
		case 'actions':
			$edit_link = get_edit_post_link($post_id);
			$delete_link = get_delete_post_link($post_id);

			echo '<a href="' . esc_url($edit_link) . '">編集</a>';
			if ($edit_link) {
				echo ' | <a href="' . esc_url($delete_link) . '" class="submitdelete">削除</a>';
			} else {
				echo '—';
			}
			break;
	}
}
add_action('manage_j1_games_posts_custom_column', 'j1_games_custom_column', 10, 2);

function j1_games_sortable_columns($columns) {
	$columns['game_datetime'] = 'game_datetime';
	$columns['open_datetime'] = 'open_datetime';
	return $columns;
}
add_filter('manage_edit-j1_games_sortable_columns', 'j1_games_sortable_columns');

// ルヴァンカップ試合結果にカスタムカラムを追加
function levain_games_columns($columns) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['game_name'] = '試合名';
	$new_columns['opponent_club'] = '対戦相手';
	$new_columns['game_datetime'] = '試合日時';
	$new_columns['post_status'] = '公開状態';
	$new_columns['open_datetime'] = '公開開始日時';
	$new_columns['close_datetime'] = '公開終了日時';
	$new_columns['actions'] = '編集';
	return $new_columns;
}
add_filter('manage_levain_games_posts_columns', 'levain_games_columns');

// ルヴァンカップ試合結果に値を表示
function levain_games_custom_column($column, $post_id) {
	switch ($column) {
		case 'game_name':
			$game_name = get_field('game_name', $post_id);
			$edit_link = get_edit_post_link($post_id);
			if ($game_name && $edit_link) {
				echo '<a href="' . esc_url($edit_link) . '">' . esc_html($game_name) . '</a>';
			} else {
				echo '—';
			}
			break;
		case 'opponent_club':
			$opponent_club_id = get_field('opponent_club', $post_id);
			if ($opponent_club_id) {	
				$club_name = get_field('opponent_club', $opponent_club_id);
				echo $club_name ? esc_html($club_name) : '—';
			} else {
				echo '—';
			}
			break;	
		case 'game_datetime':
			$game_datetime = get_field('game_datetime', $post_id);
			if ($game_datetime) {
				echo esc_html(date('Y時m月d日 H時i分', strtotime($game_datetime)));
			} else {
				echo '—';
			}
			break;
		case 'post_status':
			$status = get_post_status($post_id);
			$status_labels = array(
				'publish' => '公開済み',
				'draft' => '下書き',
				'pending' => 'レビュー待ち',
				'private' => '非公開',
			);
			echo isset($status_labels[$status]) ? esc_html($status_labels[$status]) : esc_html($status);
			break;
		case 'open_datetime':
			$open_datetime = get_field('open_datetime', $post_id);
			if ($open_datetime) {
				echo esc_html(date('Y時m月d日 H時i分', strtotime($open_datetime)));
			} else {
				echo '—';
			}
			break;
		case 'close_datetime':
			$close_datetime = get_field('close_datetime', $post_id);
			if ($close_datetime) {
				echo esc_html(date('Y時m月d日 H時i分', strtotime($close_datetime)));
			} else {
				echo '—';
			}
			break;
		case 'actions':
			$edit_link = get_edit_post_link($post_id);
			$delete_link = get_delete_post_link($post_id);

			echo '<a href="' . esc_url($edit_link) . '">編集</a>';
			if ($edit_link) {			
				echo ' | <a href="' . esc_url($delete_link) . '" class="submitdelete">削除</a>';
			} else {
				echo '—';
			}
			break;
	}
}
add_action('manage_levain_games_posts_custom_column', 'levain_games_custom_column', 10, 2);

function levain_games_sortable_columns($columns) {
	$columns['game_datetime'] = 'game_datetime';
	$columns['open_datetime'] = 'open_datetime';
	return $columns;
}
add_filter('manage_edit-levain_games_sortable_columns', 'levain_games_sortable_columns');

// その他の試合にカスタムカラムを追加
function other_games_columns($columns) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['game_name'] = '試合名';
	$new_columns['opponent_club'] = '対戦相手';
	$new_columns['game_datetime'] = '試合日時';
	$new_columns['post_status'] = '公開状態';
	$new_columns['open_datetime'] = '公開開始日時';
	$new_columns['close_datetime'] = '公開終了日時';
	$new_columns['actions'] = '編集';
	return $new_columns;
}
add_filter('manage_other_games_posts_columns', 'other_games_columns');

// その他の試合に値を表示
function other_games_custom_column($column, $post_id) {
	switch ($column) {
		case 'game_name':
			$game_name = get_field('game_name', $post_id);
			$edit_link = get_edit_post_link($post_id);
			if ($game_name && $edit_link) {
				echo '<a href="' . esc_url($edit_link) . '">' . esc_html($game_name) . '</a>';
			} else {
				echo '—';
			}
			break;
		case 'opponent_club':
			$opponent_club_id = get_field('opponent_club', $post_id);
			if ($opponent_club_id) {	
				$club_name = get_field('opponent_club', $opponent_club_id);
				echo $club_name ? esc_html($club_name) : '—';
			} else {
				echo '—';
			}
			break;	
		case 'game_datetime':
			$game_datetime = get_field('game_datetime', $post_id);
			if ($game_datetime) {
				echo esc_html(date('Y時m月d日 H時i分', strtotime($game_datetime)));
			} else {
				echo '—';
			}
			break;
		case 'post_status':
			$status = get_post_status($post_id);
			$status_labels = array(
				'publish' => '公開済み',
				'draft' => '下書き',
				'pending' => 'レビュー待ち',
				'private' => '非公開',
			);
			echo isset($status_labels[$status]) ? esc_html($status_labels[$status]) : esc_html($status);
			break;
		case 'open_datetime':
			$open_datetime = get_field('open_datetime', $post_id);
			if ($open_datetime) {
				echo esc_html(date('Y時m月d日 H時i分', strtotime($open_datetime)));
			} else {
				echo '—';
			}
			break;
		case 'close_datetime':
			$close_datetime = get_field('close_datetime', $post_id);
			if ($close_datetime) {
				echo esc_html(date('Y時m月d日 H時i分', strtotime($close_datetime)));
			} else {
				echo '—';
			}
			break;
		case 'actions':
			$edit_link = get_edit_post_link($post_id);
			$delete_link = get_delete_post_link($post_id);

			echo '<a href="' . esc_url($edit_link) . '">編集</a>';
			if ($edit_link) {
				echo ' | <a href="' . esc_url($delete_link) . '" class="submitdelete">削除</a>';
			} else {
				echo '—';
			}
			break;
	}
}

function other_games_sortable_columns($columns) {
	$columns['game_datetime'] = 'game_datetime';
	$columns['open_datetime'] = 'open_datetime';
	return $columns;
}
add_filter('manage_edit-other_games_sortable_columns', 'other_games_sortable_columns');

// 試合一覧の並び替え処理
function games_orderby($query) {
	if (!is_admin() || !$query->is_main_query()) {
		return;
	}
	$orderby = $query->get('orderby');

	if ('game_datetime' === $orderby) {
		$query->set('meta_key', 'game_datetime');
		$query->set('orderby', 'meta_value');
	}

	if ('open_datetime' === $orderby) {
		$query->set('meta_key', 'open_datetime');
		$query->set('orderby', 'meta_value');
	}
}
add_action('pre_get_posts', 'games_orderby');

// 大会情報にカスタムカラムを追加
function tournaments_columns($columns) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['tournament_name'] = '大会名';
	$new_columns['tournament_abbreviation'] = '大会略称名';
	$new_columns['tournament_logo'] = '大会ロゴ';
	$new_columns['actions'] = '編集';
	return $new_columns;
}
add_filter('manage_tournaments_posts_columns', 'tournaments_columns');

// 大会情報に値を表示
function tournaments_custom_column($column, $post_id) {
	switch ($column) {
		case 'tournament_name':
			$tournament_name = get_field('tournament_name', $post_id);
			$edit_link = get_edit_post_link($post_id);
			if ($tournament_name && $edit_link) {
				echo '<a href="' . esc_url($edit_link) . '">' . esc_html($tournament_name) . '</a>';
			} elseif ($tournament_name) {
				echo esc_html($tournament_name);
			} else {
				echo '—';
			}
			break;
		case 'tournament_abbreviation':
			$tournament_abbreviation = get_field('tournament_abbreviation', $post_id);
			echo $tournament_abbreviation ? esc_html($tournament_abbreviation) : '—';
			break;
		case 'tournament_logo':
			$tournament_logo = get_field('tournament_logo', $post_id);
			if ($tournament_logo) {
				echo '<img src="' . esc_url( $tournament_logo ) . '" style="max-width: 60px; max-height: 60px;" />';
			} else {
				echo '—';
			}
			break;
		case 'actions':
			$edit_link = get_edit_post_link($post_id);
			$delete_link = get_delete_post_link($post_id);

			echo '<a href="' . esc_url($edit_link) . '">編集</a>';
			if ($edit_link) {			
				echo ' | <a href="' . esc_url($delete_link) . '" class="submitdelete">削除</a>';
			}
			break;
	}
}
add_action('manage_tournaments_posts_custom_column', 'tournaments_custom_column');

// チーム情報にカスタムカラムを追加
function teams_columns($columns) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['team_name'] = 'チーム名';
	$new_columns['team_abbreviation'] = 'チーム名略称';
	$new_columns['team_emblem'] = 'チームロゴ画像';
	$new_columns['actions'] = '編集';
	return $new_columns;
}
add_filter('manage_teams_posts_columns', 'teams_columns');

// チーム情報に値を表示
function twentytwentyfive_teams_custom_column($column, $post_id) {
	switch ($column) {
		case 'team_name':
			$team_name = get_field('team_name', $post_id);
			$edit_link = get_edit_post_link($post_id);
			if ($team_name && $edit_link) {
				echo '<a href="' . esc_url($edit_link) . '">' . esc_html($team_name) . '</a>';
			} elseif ($team_name) {
				echo esc_html( $team_name );
			} else {
				echo '—';
			}
			break;
		case 'team_abbreviation':
			$team_abbreviation = get_field('team_abbreviation', $post_id);
			echo $team_abbreviation ? esc_html($team_abbreviation) : '—';
			break;
		case 'team_emblem':
			$team_emblem = get_field('team_emblem_url', $post_id);
			if ($team_emblem) {
				echo '<img src="' . esc_url($team_emblem) . '" style="max-width: 60px; max-height: 60px;" />';
			} else {
				echo '—';
			}
			break;
		case 'actions':
			$edit_link = get_edit_post_link($post_id);
			$delete_link = get_delete_post_link($post_id);
			
			echo '<a href="' . esc_url($edit_link) . '">編集</a>';
			if ($delete_link) {
				echo ' | <a href="' . esc_url($delete_link) . '" class="submitdelete">削除</a>';
			}
			break;
	}
}
add_action('manage_teams_posts_custom_column', 'twentytwentyfive_teams_custom_column', 10, 2);

// お知らせにカスタムカラムを追加
function notifications_columns( $columns ) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['title'] = 'タイトル';
	$new_columns['open_datetime'] = '公開日時';
	$new_columns['close_datetime'] = '終了日時';
	$new_columns['actions'] = '編集';
	return $new_columns;
}
add_filter('manage_notifications_posts_columns', 'notifications_columns');

// お知らせに値を表示
function notifications_custom_column($column, $post_id) {
	switch ($column) {
		case 'title':
			$title = get_the_title($post_id);
			$edit_link = get_edit_post_link($post_id);
			if ($title && $edit_link) {
				echo '<a href="' . esc_url($edit_link) . '">' . esc_html($title) . '</a>';
			} elseif ($title) {
				echo esc_html($title);
			} else {
				echo '—';
			}
			break;
		case 'open_datetime':
			$open_datetime = get_field('open_datetime', $post_id);
			if ($open_datetime) {
				echo esc_html(date('Y時m月d日 H時i分', strtotime($open_datetime)));
			} else {
				echo '—';
			}
			break;
		case 'close_datetime':
			$close_datetime = get_field('close_datetime', $post_id);
			if ($close_datetime) {
				echo esc_html(date('Y時m月d日 H時i分', strtotime($close_datetime)));
			} else {
				echo '—';
			}
			break;
		case 'actions':
			$edit_link = get_edit_post_link($post_id);
			$delete_link = get_delete_post_link($post_id);

			echo '<a href="' . esc_url($edit_link) . '">編集</a>';
			if ($delete_link) {			
				echo ' | <a href="' . esc_url($delete_link) . '" class="submitdelete">削除</a>';
			}
			break;
	}
}
add_action('manage_notifications_posts_custom_column', 'notifications_custom_column', 10, 2);

function notifications_sortable_columns($columns) {
	$columns['open_datetime'] = 'open_datetime';
	return $columns;
}
add_filter('manage_edit-notifications_sortable_columns', 'notifications_sortable_columns');

// 通常動画管理にカスタムカラムを追加
function ordinary_video_columns($columns) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['thumbnail'] = 'サムネイル';
	$new_columns['filename'] = 'ファイル名';
	$new_columns['order'] = '並び順';
	$new_columns['actions'] = '編集';
	return $new_columns;
}
add_filter('manage_ordinary_video_posts_columns', 'ordinary_video_columns');

// 通常動画管理に値を表示
function ordinary_video_custom_column($column, $post_id) {
	switch ($column) {
		case 'thumbnail':
			$ordinary_video_url = get_field('ordinary_video_url', $post_id);
			if ( $ordinary_video_url ) {
				echo '<video style="max-width: 240px; max-height: 240px;" muted><source src="' . esc_url( $ordinary_video_url ) . '" type="video/mp4"></video>';
			} else {
				echo '—';
			}
			break;
		case 'filename':
			$ordinary_video_url = get_field('ordinary_video_url', $post_id);
			if ($ordinary_video_url) {
				$filename = basename($ordinary_video_url);
				echo esc_html($filename);
			} else {
				echo '—';
			}
			break;
		case 'order':
			$order = get_field('order', $post_id);
			if ($order) {
				echo esc_html($order);
			} else {
				echo '—';
			}
			break;
		case 'actions':
			$edit_link = get_edit_post_link($post_id);
			$delete_link = get_delete_post_link($post_id);

			echo '<a href="' . esc_url($edit_link) . '">編集</a>';
			if ($delete_link) {
				echo ' | <a href="' . esc_url($delete_link) . '" class="submitdelete">削除</a>';
			}
			break;
	}
}
add_action('manage_ordinary_video_posts_custom_column', 'ordinary_video_custom_column', 10, 2);

// デフォルト動画一覧にカスタムカラムを追加
function default_video_columns($columns) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['thumbnail'] = 'サムネイル';
	$new_columns['filename'] = 'ファイル名';
	$new_columns['order'] = '並び順';
	$new_columns['actions'] = '編集';
	return $new_columns;
}
add_filter('manage_default_video_posts_columns', 'default_video_columns');

// デフォルト動画一覧に値を表示
function default_video_custom_column($column, $post_id) {
	switch ($column) {
		case 'thumbnail':
			$default_video_url = get_field('default_video_url', $post_id);
			if ($default_video_url) {
				echo '<video style="max-width: 240px; max-height: 240px;" muted><source src="' . esc_url( $default_video_url ) . '" type="video/mp4"></video>';
			} else {
				echo '—';
			}
			break;
		case 'filename':
			$default_video_url = get_field('default_video_url', $post_id);
			if ($default_video_url) {
				$filename = basename($default_video_url);
				echo esc_html($filename);
			} else {
				echo '—';
			}
			break;
		case 'order':
			$order = get_field('order', $post_id);
			if ($order) {
				echo esc_html($order);
			} else {
				echo '—';
			}
			break;
		case 'actions':
			$edit_link = get_edit_post_link($post_id);
			$delete_link = get_delete_post_link($post_id);

			echo '<a href="' . esc_url($edit_link) . '">編集</a>';
			if ($delete_link) {
				echo ' | <a href="' . esc_url($delete_link) . '" class="submitdelete">削除</a>';
			}
			break;
	}
}
add_action('manage_default_video_posts_custom_column', 'default_video_custom_column');

// エラー動画一覧にカスタムカラムを追加
function error_video_columns($columns) {
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['thumbnail'] = 'サムネイル';
	$new_columns['filename'] = 'ファイル名';
	$new_columns['order'] = '並び順';
	$new_columns['actions'] = '編集';
	return $new_columns;
}
add_filter('manage_error_video_posts_columns', 'error_video_columns');

// エラー動画一覧に値を表示
function error_video_custom_column($column, $post_id) {
	switch ($column) {
		case 'thumbnail':
			$error_video_url = get_field('error_video_url', $post_id);
			if ($error_video_url) {
				echo '<video style="max-width: 240px; max-height: 240px;" muted><source src="' . esc_url( $error_video_url ) . '" type="video/mp4"></video>';
			} else {
				echo '—';
			}
			break;
		case 'filename':
			$error_video_url = get_field('error_video_url', $post_id);
			if ($error_video_url) {
				$filename = basename($error_video_url);
				echo esc_html($filename);
			} else {
				echo '—';
			}
			break;
		case 'actions':
			$edit_link = get_edit_post_link($post_id);
			$delete_link = get_delete_post_link($post_id);

			echo '<a href="' . esc_url($edit_link) . '">編集</a>';
			if ($delete_link) {
				echo ' | <a href="' . esc_url($delete_link) . '" class="submitdelete">削除</a>';
			}
			break;
	}
}
add_action('manage_error_video_posts_custom_column', 'error_video_custom_column');	

// デフォルトの行アクションを非表示にするCSSを追加	
function hide_row_actions_css() {
	$screen = get_current_screen();
	if ($screen  && in_array($screen->id, array('edit-j1_games', 'edit-levain_games', 'edit-other_games', 'edit-tournaments', 'edit-teams', 'edit-notifications', 'edit-ordinary_video', 'edit-default_video', 'edit-error_video'))) {
		echo '<style>
		.row-actions {
			display: none;
		}
		</style>';
	}
}
add_action('admin_head', 'hide_row_actions_css');

// Load custom REST API endpoints in theme/api
if ( file_exists( get_template_directory() . '/api/signage/games.php' ) ) {
	require_once get_template_directory() . '/api/signage/games.php';
}