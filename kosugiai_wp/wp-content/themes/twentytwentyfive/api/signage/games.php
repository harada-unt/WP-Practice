<?php

/**
 * 試合API登録
 *  @param WP_REST_Server $rest_server
 */ 
add_action('rest_api_init', function () {
    register_rest_route('v1/signage', '/games', [
        'methods' => WP_REST_Server::READABLE,
        'callback' => 'get_games_data',
        'args' => get_games_fields()
    ]);
});

/**
 * 試合APIフィールド定義
 *
 * @return array
 */
function get_games_fields() {
    return  [
        'time' => [
            'required' => false,
            'type' => 'date-time',
            'description' => '更新日時',
        ],

        'game' => [
            'id' => [
                'required' => true,
                'type' => 'integer',
                'description' => 'ゲームID',
            ],
            'open_datetime' => [
                'required' => true,
                'type' => 'date-time',
                'description' => '公開開始日時ISO 8601形式',
            ],
            'close_datetime' => [
                'required' => true,
                'type' => 'date-time',
                'description' => '公開終了日時ISO 8601形式',
            ],
            'update_datetime' => [
                'required' => true,
                'type' => 'date-time',
                'description' => '試合情報更新日時ISO 8601形式',
            ],
            'tournament' => [
                'type' => 'object',
                'description' => '大会情報',
                'properties' => [
                    'name' => [
                        'required' => true,
                        'type' => 'string',
                        'description' => '大会名称',
                    ],
                    'abbreviation' => [
                        'required' => true,
                        'type' => 'string',
                        'description' => '大会名略称',
                    ],
                    'logo_url' => [
                        'required' => false,
                        'type' => 'string',
                        'description' => '大会ロゴ画像',
                    ],
                ],
            ],
            'date'=> [
                'type' => 'object',
                'description' => '試合日時情報',
                'properties' => [
                    'datetime' => [
                        'required' => true,
                        'type' => 'date-time',
                        'description' => '試合日時ISO 8601形式',
                    ],
                    'label' => [
                        'required' => true,
                        'type' => 'string',
                        'description' => '試合日時の日本語表',
                    ],
                ],
            ],
            'status' => [
                'required' => false,
                'type' => 'string',
                'description' => '試合ステータス',
            ],
            'side' => [
                'required' => true,
                'type' => 'string',
                'description' => '試合本拠地',
            ],
            'name' => [
                'required' => true,
                'type' => 'string',
                'description' => '試合名称'
            ],
            'home' => [
                'type' => 'object',
                'description' => 'ホーム情報',
                'properties' => [
                    'team' => [
                        'type' => 'object',
                        'description' => 'ホームチーム情報',
                        'properties' => [
                            'name' => [
                                'required' => true,
                                'type' => 'string',
                                'description' => 'チーム名',
                            ],
                            'abbreviation' => [
                                'required' => true,
                                'type' => 'string',
                                'description' => 'チーム名略称',
                            ],
                            'emblem_url' => [
                                'required' => true,
                                'type' => 'string',
                                'description' => 'チームロゴ',
                            ]
                        ]
                    ],
                    'scores' => [
                        'type' => 'object',
                        'description' => 'スコア情報',
                        'properties' => [
                            'total' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '合計得点',
                            ],
                            'half1' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '前半得点',
                            ],
                            'half2' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '後半得点',
                            ],
                            'extra_half1' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '延長前半得点',
                            ],
                            'extra_half2' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '延長後半得点',
                            ],
                            'pk' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => 'PK得点',
                            ],
                            'first_game' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '1st得点',
                            ],
                        ]
                    ],
                    'score_players' => [
                        'type' => 'array',
                        'description' => '得点者情報',
                        'items' => [
                            'type' => 'object',
                            'properties' => [
                                'name' => [
                                    'required' => false,
                                    'type' => 'string',
                                    'description' => '得点者名',
                                ],
                                'time' => [
                                    'required' => false,
                                    'type' => 'string',
                                    'description' => '得点時間',
                                ],
                            ],
                        ],
                    ]
                ]     
            ],
            'away' => [
                'type' => 'object',
                'description' => 'アウェイ情報',
                'properties' => [
                    'team' => [
                        'type' => 'object',
                        'description' => 'アウェイチーム情報',
                        'properties' => [
                            'name' => [
                                'required' => true,
                                'type' => 'string',
                                'description' => 'チーム名',
                            ],
                            'abbreviation' => [
                                'required' => true,
                                'type' => 'string',
                                'description' => 'チーム名略称',
                            ],
                            'emblem_url' => [
                                'required' => true,
                                'type' => 'string',
                                'description' => 'チームロゴ',
                            ]
                        ]
                    ],
                    'scores' => [
                        'type' => 'object',
                        'description' => 'スコア情報',
                        'properties' => [
                            'total' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '合計得点',
                            ],
                            'half1' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '前半得点',
                            ],
                            'half2' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '後半得点',
                            ],
                            'extra_half1' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '延長前半得点',
                            ],
                            'extra_half2' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '延長後半得点',
                            ],
                            'pk' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => 'PK得点',
                            ],
                            'first_game' => [
                                'required' => false,
                                'type' => 'integer',
                                'description' => '1st得点',
                            ],
                        ]
                    ],
                    'score_players' => [
                        'type' => 'array',
                        'description' => '得点者情報',
                        'items' => [
                            'type' => 'object',
                            'properties' => [
                                'name' => [
                                    'required' => false,
                                    'type' => 'string',
                                    'description' => '得点者名',
                                ],
                                'time' => [
                                    'required' => false,
                                    'type' => 'string',
                                    'description' => '得点時間',
                                ],
                            ],  
                        ],
                    ]       
                ]           
            ],
            'interview' => [
                'type' => 'object',
                'description' => 'インタービュー動画',
                'properties' => [
                    'video' => [
                        'type' => 'object',
                        'description' => '動画情報',
                        'properties' => [
                            'url' => [
                                'required' => true,
                                'type' => 'string',
                                'description' => '動画URL',
                            ],
                        ]
                    ]
                ]
            ]
        ],

        'videos' => [
            'type' => 'object',
            'description' => '動画情報',
            'properties' => [
                'interview' => [
                    'type' => 'array',
                    'description' => 'インタービュー動画',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'url' => [
                                'required' => false,
                                'type' => 'string',
                                'description' => '動画URL',
                            ],
                            'update_datetime' => [
                                'required' => false,
                                'type' => 'date-time',
                                'description' => '動画更新日時（ISO 8601形式）',
                            ]
                        ]
                    ]
                ],
                'ordinary' => [
                    'type' => 'array',
                    'description' => '通常動画',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'url' => [
                                'required' => false,
                                'type' => 'string',
                                'description' => '通常動画URL',
                            ],
                            'update_datetime' => [
                                'required' => false,
                                'type' => 'date-time',
                                'description' => '動画更新日時（ISO 8601形式）',
                            ]
                        ]
                    ]
                ],
                'default' => [
                    'type' => 'array',
                    'description' => 'デフォルト動画',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'url' => [
                                'required' => false,
                                'type' => 'string',
                                'description' => 'デフォルト動画URL',
                            ],
                            'update_datetime' => [
                                'required' => false,
                                'type' => 'date-time',
                                'description' => '動画更新日時（ISO 8601形式）',
                            ]
                        ]
                    ]
                ],
                'error' => [
                    'type' => 'array',
                    'description' => 'エラー動画',
                    'items' => [
                        'type' => 'object',
                        'properties' => [
                            'url' => [
                                'required' => false,
                                'type' => 'string',
                                'description' => 'エラー動画URL',
                            ],
                            'update_datetime' => [
                                'required' => false,
                                'type' => 'date-time',
                                'description' => '動画更新日時（ISO 8601形式）',
                            ]
                        ]
                    ]
                ],
            ]
        ],

        'notifications' => [
            'type' => 'array',
            'description' => 'お知らせの配列',
            'items' => [
                'type' => 'object',
                'properties' => [
                    'open_datetime' => [
                        'required' => false,
                        'type' => 'date-time',
                        'description' => '公開開始日時（ISO 8601形式）',
                    ],
                    'close_datetime' => [
                        'required' => false,
                        'type' => 'date-time',
                        'description' => '公開終了日時（ISO 8601形式）',
                    ],
                    'update_datetime' => [
                        'required' => false,
                        'type' => 'date-time',
                        'description' => '更新日時（ISO 8601形式）',
                    ],
                    'url' => [
                        'required' => false,
                        'type' => 'string',
                        'description' => 'お知らせURL',
                    ]
                ],
            ]
        ],
    ];
}

function get_games_data( $request ) {    
    $params = $request->get_params();
    $update_time = isset( $params['time'] ) ? $params['time'] : null;
    
    $current_datetime = current_time( 'mysql' );
  
    $args = array(
        'post_type'      => array( 'j1_games', 'levain_games', 'other_games' ),
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'orderby'        => 'meta_value',
        'meta_key'       => 'open_datetime',
        'order'          => 'DESC',
        'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key'     => 'open_datetime',
                'value'   => $current_datetime,
                'compare' => '<=',
                'type'    => 'DATETIME',
            ),
            array(
                'key'     => 'close_datetime',
                'value'   => $current_datetime,
                'compare' => '>=',
                'type'    => 'DATETIME',
            ),
        ),
    );
        
    $query = new WP_Query( $args );
    $game_data = null;
    $interview_url = '';
    
    if ( $query->have_posts() ) {
        $query->the_post();
        $post_id = get_the_ID();
        $interview_url = get_field( 'interview', $post_id );
        $game_data = build_game_data($post_id );
    }
    wp_reset_postdata();
    
    $notifications = get_notifications_data( $current_datetime );
    $videos = get_videos_data( $interview_url );
    
    $response_data = array(
        'time' => current_time( 'c' ),
        'game' => $game_data ? $game_data : new stdClass(), 
        'videos' => $videos,
        'notifications' => $notifications,
    );
    
    return new WP_REST_Response( $response_data, 200 );
}

function build_game_data($post_id) {
    $open_datetime = get_field( 'open_datetime', $post_id );
    $close_datetime = get_field( 'close_datetime', $post_id );

    $post_type = get_post_type( $post_id );
    $tournament_post_id = null;
    
    if ( $post_type === 'j1_games' ) {
        $tournament_post_id = 181; // J1試合結果のURL
    } elseif ( $post_type === 'levain_games' ) {
        $tournament_post_id = 183; // ルヴァンカップ試合結果のURL
    }
    
    // 試合結果のURL    
    $tournament_name = $tournament_post_id ? get_field( 'tournament_name', $tournament_post_id ) : '';
    $tournament_abbreviation = $tournament_post_id ? get_field( 'tournament_abbreviation', $tournament_post_id ) : '';
    $tournament_logo = $tournament_post_id ? get_field( 'tournament_logo', $tournament_post_id ) : '';

    $game_datetime = get_field( 'game_datetime', $post_id );
    // 試合日時ラベル作成
    $game_date_label = '';
    if ( ! empty( $game_datetime ) ) {
        $timestamp = strtotime( $game_datetime );
        $weekdays = array( '日', '月', '火', '水', '木', '金', '土' );
        $weekday = $weekdays[ date( 'w', $timestamp ) ];
        $game_date_label = date( 'Y年n月j日', $timestamp ) . '(' . $weekday . ')';
    }
    $game_status = get_field( 'game_status', $post_id );
    $game_side = get_field( 'game_side', $post_id );
    $game_name = get_field( 'game_name', $post_id );

    if ( $post_type === 'j1_games' ) {
        $opponent_club_id = get_field( 'opponent_club', $post_id );
        if ($game_side === 'HOME' ) {
                $home_team_id = 188;
                $away_team_id = $opponent_club_id;
            } elseif ( $game_side === 'AWAY' ) {
                $home_team_id = $opponent_club_id;
                $away_team_id = 188;
            } 
    } else {
        if ($game_side === 'HOME' ) {
                $home_team_id = 188;
                $away_team_id = $post_id;
            } elseif ( $game_side === 'AWAY' ) {
                $home_team_id = $post_id;
                $away_team_id = 188;
            } 
    }
        
    // ホームチーム情報
    $home_team_name = get_field( 'team_name', $home_team_id );
    $home_team_abbreviation = get_field( 'team_abbreviation', $home_team_id );
    $home_team_emblem = get_field( 'team_emblem_url', $home_team_id );
    $home_score_total = get_field( 'scores_home_total', $post_id );
    $home_score_half1 = get_field( 'scores_home_half1', $post_id );
    $home_score_half2 = get_field( 'scores_home_half2', $post_id );
    $home_score_extra_half1 = get_field( 'scores_home_extra_half1', $post_id );
    $home_score_extra_half2 = get_field( 'scores_home_extra_half2', $post_id );
    $home_score_pk = get_field( 'scores_home_pk', $post_id );
    $home_score_first_game = get_field( 'scores_home_first_game', $post_id );
    
    // アウェイチーム情報
    $away_team_name = get_field( 'team_name', $away_team_id );
    $away_team_abbreviation = get_field( 'team_abbreviation', $away_team_id );
    $away_team_emblem = get_field( 'team_emblem_url', $away_team_id );
    $away_score_total = get_field( 'scores_away_total', $post_id );
    $away_score_half1 = get_field( 'scores_away_half1', $post_id );
    $away_score_half2 = get_field( 'scores_away_half2', $post_id );
    $away_score_extra_half1 = get_field( 'scores_away_extra_half1', $post_id );
    $away_score_extra_half2 = get_field( 'scores_away_extra_half2', $post_id );
    $away_score_pk = get_field( 'scores_away_pk', $post_id );
    $away_score_first_game = get_field( 'away_score_first_game', $post_id );
    
    // インタビュー動画
    $interview_video_url = get_field( 'interview', $post_id );
    
    // スコア選手情報
    $home_players = get_score_players_data( $post_id, 'home' );
    $away_players = get_score_players_data( $post_id, 'away' );
    
    // 試合情報配列作成
    return array(
        'id' => $post_id,
        'open_datetime' => format_datetime( $open_datetime ),
        'close_datetime' => format_datetime( $close_datetime ),
        'update_datetime' => get_the_modified_date( 'c', $post_id ),
        'tournament' => array(
            'name' => $tournament_name ? $tournament_name : '',
            'abbreviation' => $tournament_abbreviation ? $tournament_abbreviation : '',
            'logo_url' => $tournament_logo ? $tournament_logo : '',
        ),
        'date' => array(
            'datetime' => format_datetime( $game_datetime ),
            'label' => $game_date_label ? $game_date_label : '',
        ),
        'status' => $game_status ? $game_status : '',
        'side' => $game_side ? $game_side : '',
        'name' => $game_name ? $game_name : get_the_title( $post_id ),
        'home' => array(
            'team' => array(
                'name' => $home_team_name ? $home_team_name : '',
                'abbreviation' => $home_team_abbreviation ? $home_team_abbreviation : '',
                'emblem_url' => $home_team_emblem ? $home_team_emblem : '',
            ),
            'scores' => array(
                'total' => $home_score_total !== null ? (int) $home_score_total : null,
                'half1' => $home_score_half1 !== null ? (int) $home_score_half1 : null,
                'half2' => $home_score_half2 !== null ? (int) $home_score_half2 : null,
                'extra_half1' => $home_score_extra_half1 !== null ? (int) $home_score_extra_half1 : null,
                'extra_half2' => $home_score_extra_half2 !== null ? (int) $home_score_extra_half2 : null,
                'pk' => $home_score_pk !== null ? (int) $home_score_pk : null,
                'first_game' => $home_score_first_game !== null ? (int) $home_score_first_game : null,
            ),
            'score_players' => $home_players,
        ),
        'away' => array(
            'team' => array(
                'name' => $away_team_name ? $away_team_name : '',
                'abbreviation' => $away_team_abbreviation ? $away_team_abbreviation : '',
                'emblem_url' => $away_team_emblem ? $away_team_emblem : '',
            ),
            'scores' => array(
                'total' => $away_score_total !== null ? (int) $away_score_total : null,
                'half1' => $away_score_half1 !== null ? (int) $away_score_half1 : null,
                'half2' => $away_score_half2 !== null ? (int) $away_score_half2 : null,
                'extra_half1' => $away_score_extra_half1 !== null ? (int) $away_score_extra_half1 : null,
                'extra_half2' => $away_score_extra_half2 !== null ? (int) $away_score_extra_half2 : null,
                'pk' => $away_score_pk !== null ? (int) $away_score_pk : null,
                'first_game' => $away_score_first_game !== null ? (int) $away_score_first_game : null,
            ),
            'score_players' => $away_players,
        ),
        'interview' => array(
            'video' => array(
                'url' => $interview_video_url ? $interview_video_url : '',
            ),
        ),
    );
}

function get_notifications_data( $current_datetime ) {    
    $args = array(
        'post_type'      => 'notifications',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_key'       => 'open_datetime',
        'order'          => 'DESC',
        'meta_query'     => array(
            'relation' => 'AND',
            array(
                'key'     => 'open_datetime',
                'value'   => $current_datetime,
                'compare' => '<=',
                'type'    => 'DATETIME',
            ),
            array(
                'key'     => 'close_datetime',
                'value'   => $current_datetime,
                'compare' => '>=',
                'type'    => 'DATETIME',
            ),
        ),
    );
    
    $query = new WP_Query( $args );
    $notifications = array();
    
    if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
            $query->the_post();
            $post_id = get_the_ID();
            
            $open_datetime = get_field( 'open_datetime', $post_id );
            $close_datetime = get_field( 'close_datetime', $post_id );
            $image_url = get_field( 'image_url', $post_id );
            
            $notifications[] = array(
                'open_datetime' => format_datetime( $open_datetime ),
                'close_datetime' => format_datetime( $close_datetime ),
                'update_datetime' => get_the_modified_date( 'c', $post_id ),
                'url' => $image_url ? $image_url : '',
            );
        }
    }
    wp_reset_postdata();
    
    return $notifications;
}

function get_videos_data( $interview_url = '' ) {
    $ordinary_args = array(
        'post_type'      => 'ordinary_video',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'order',
        'order'          => 'ASC',
    );
    $ordinary_query = new WP_Query( $ordinary_args );
    $ordinary_videos = array();
    
    if ( $ordinary_query->have_posts() ) {
        while ( $ordinary_query->have_posts() ) {
            $ordinary_query->the_post();
            $ordinary_post_id = get_the_ID();
            $video_url = get_field( 'ordinary_video_url', $ordinary_post_id );
            
            if ( ! empty( $video_url ) ) {
                $ordinary_videos[] = array(
                    'url' => $video_url,
                    'update_datetime' => get_the_modified_date( 'c', $ordinary_post_id ),
                );
            }
        }
    }
    wp_reset_postdata();
    
    // デフォルト動画情報
    $default_args = array(
        'post_type'      => 'default_video',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'order',
        'order'          => 'ASC',
    );
    $default_query = new WP_Query( $default_args );
    $default_videos = array();
    
    if ( $default_query->have_posts() ) {
        while ( $default_query->have_posts() ) {
            $default_query->the_post();
            $default_post_id = get_the_ID();
            $video_url = get_field( 'default_video_url', $default_post_id );
            
            if ( ! empty( $video_url ) ) {
                $default_videos[] = array(
                    'url' => $video_url,
                    'update_datetime' => get_the_modified_date( 'c', $default_post_id ),
                );
            }
        }
    }
    wp_reset_postdata();
    
    // エラービデオ情報 
    $error_args = array(
        'post_type'      => 'error_video',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value_num',
        'meta_key'       => 'order',
        'order'          => 'ASC',
    );
    $error_query = new WP_Query( $error_args );
    $error_videos = array();
    
    if ( $error_query->have_posts() ) {
        while ( $error_query->have_posts() ) {
            $error_query->the_post();
            $error_post_id = get_the_ID();
            $video_url = get_field( 'error_video_url', $error_post_id );
            
            if ( ! empty( $video_url ) ) {
                $error_videos[] = array(
                    'url' => $video_url,
                    'update_datetime' => get_the_modified_date( 'c', $error_post_id ),
                );
            }
        }
    }
    wp_reset_postdata();
    
    // インタビュー動画情報
    $interview_videos = array();
    if ( ! empty( $interview_url ) ) {
        $interview_videos[] = array(
            'url' => $interview_url,
            'update_datetime' => current_time( 'c' ),
        );
    }
    
    return array(
        'interview' => $interview_videos,
        'ordinary' => $ordinary_videos,
        'default' => $default_videos,
        'error' => $error_videos,
    );
}

/**
 * 日付をISO 8601形式にフォーマットする
 * @param string $datetime 日付文字列
 * @return string フォーマット後の日付文字列 */
function format_datetime( $datetime ) {
    if ( empty( $datetime ) ) {
        return '';
    }
    
    // すでにISO 8601形式の場合はそのまま返す
    if ( strpos( $datetime, 'T' ) !== false ) {
        return $datetime;
    }
    
    // MySQL形式の日付をISO 8601形式に変換
    return date( 'c', strtotime( $datetime ) );
}

/**
 * 得点選手データを取得する (1〜4番目、5〜8番目、9〜12番目)
 *
 * @param int $post_id 投稿ID
 * @param string $team チーム('home' または 'away')
 * @return array 得点選手の配列
 */
function get_score_players_data( $post_id, $team ) {
    $players = array();
    
    // グループ1: score1~score4 (1番目〜4番目)
    $group1_field = $team . '_score_players1';
    $group1_data = get_field( $group1_field, $post_id );
    
    if ( $group1_data ) {
        for ( $i = 1; $i <= 4; $i++ ) {
            $score_field = 'score' . $i;
            if ( isset( $group1_data[ $score_field ] ) ) {
                $score_data = $group1_data[ $score_field ];
                if ( ! empty( $score_data['name'] ) || ! empty( $score_data['time'] ) ) {
                    $players[] = array(
                        'name' => isset( $score_data['name'] ) ? $score_data['name'] : '',
                        'time' => isset( $score_data['time'] ) ? $score_data['time'] : '',
                    );
                }
            }
        }
    }
    
    // グループ2: score5~score8 (5番目〜8番目)
    $group2_field = $team . '_score_players2';
    $group2_data = get_field( $group2_field, $post_id );
    
    if ( $group2_data ) {
        for ( $i = 5; $i <= 8; $i++ ) {
            $score_field = 'score' . $i;
            if ( isset( $group2_data[ $score_field ] ) ) {
                $score_data = $group2_data[ $score_field ];
                if ( ! empty( $score_data['name'] ) || ! empty( $score_data['time'] ) ) {
                    $players[] = array(
                        'name' => isset( $score_data['name'] ) ? $score_data['name'] : '',
                        'time' => isset( $score_data['time'] ) ? $score_data['time'] : '',
                    );
                }
            }
        }
    }
    
    // グループ3: score9~score12 (9番目〜12番目)
    $group3_field = $team . '_score_players3';
    $group3_data = get_field( $group3_field, $post_id );
    
    if ( $group3_data ) {
        for ( $i = 9; $i <= 12; $i++ ) {
            $score_field = 'score' . $i;
            if ( isset( $group3_data[ $score_field ] ) ) {
                $score_data = $group3_data[ $score_field ];
                if ( ! empty( $score_data['name'] ) || ! empty( $score_data['time'] ) ) {
                    $players[] = array(
                        'name' => isset( $score_data['name'] ) ? $score_data['name'] : '',
                        'time' => isset( $score_data['time'] ) ? $score_data['time'] : '',
                    );
                }
            }
        }
    }
    
    return $players;
}
