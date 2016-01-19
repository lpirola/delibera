<?php

function delibera_Add_custom_Post()
{
	$labels = array
	(
		'name' => __('Pautas','delibera'),
	    'singular_name' => __('Pauta','delibera'),
	    'add_new' => __('Adicionar Nova','delibera'),
	    'add_new_item' => __('Adicionar nova pauta ','delibera'),
	    'edit_item' => __('Editar Pauta','delibera'),
	    'new_item' => __('Nova Pauta','delibera'),
	    'view_item' => __('Visualizar Pauta','delibera'),
	    'search_items' => __('Procurar Pautas','delibera'),
	    'not_found' =>  __('Nenhuma Pauta localizada','delibera'),
	    'not_found_in_trash' => __('Nenhuma Pauta localizada na lixeira','delibera'),
	    'parent_item_colon' => '',
	    'menu_name' => __('Pautas','delibera')

	);

	$args = array
	(
		'label' => __('Pautas','delibera'),
		'labels' => $labels,
		'description' => __('Pauta de discussão','delibera'),
		'public' => true,
		'publicly_queryable' => true, // public
		//'exclude_from_search' => '', // public
		'show_ui' => true, // public
		'show_in_menu' => true,
		'menu_position' => 5,
		// 'menu_icon' => '',
		'capability_type' => array('pauta','pautas'),
		'map_meta_cap' => true,
		'hierarchical' => false,
		'supports' => array('title', 'editor', 'author', 'excerpt', 'trackbacks', 'revisions', 'comments'),
		'register_meta_box_cb' => 'delibera_pauta_custom_meta', // função para chamar na edição
		//'taxonomies' => array('post_tag'), // Taxionomias já existentes relaciondas, vamos criar e registrar na sequência
		'permalink_epmask' => 'EP_PERMALINK ',
		'has_archive' => true, // Opção de arquivamento por slug
		'rewrite' => true,
		'query_var' => true,
		'can_export' => true//, // veja abaixo
		//'show_in_nav_menus' => '', // public
		//'_builtin' => '', // Core
		//'_edit_link' => '' // Core

	);

	register_post_type("pauta", $args);
}

function delibera_Add_custom_taxonomy()
{
	$labels = array
	(
		'name' => __('Temas', 'delibera'),
	    'singular_name' => __('Tema', 'delibera'),
		'search_items' => __('Procurar por Temas','delibera'),
		'all_items' => __('Todos os Temas','delibera'),
		'parent_item' => __( 'Tema Pai','delibera'),
		'parent_item_colon' => __( 'Tema Pai:','delibera'),
		'edit_item' => __('Editar Tema','delibera'),
		'update_item' => __('Atualizar um Tema','delibera'),
		'add_new_item' => __('Adicionar Novo Tema','delibera'),
	    'add_new' => __('Adicionar Novo','delibera'),
	    'new_item_name' => __('Novo Tema','delibera'),
	    'view_item' => __('Visualizar Tema','delibera'),
	    'not_found' =>  __('Nenhum Tema localizado','delibera'),
	    'not_found_in_trash' => __('Nenhum Tema localizado na lixeira','delibera'),
	    'menu_name' => __('Temas','delibera')
	);

	$args = array
	(
		'label' => __('Temas','delibera'),
		'labels' => $labels,
		'public' => true,
		'capabilities' => array('assign_terms' => 'edit_pautas',
								'edit_terms' => 'edit_pautas'),
		//'show_in_nav_menus' => true, // Public
		// 'show_ui' => '', // Public
		'hierarchical' => true,
		//'update_count_callback' => '', //Contar objetos associados
		'rewrite' => true,
		//'query_var' => '',
		//'_builtin' => '' // Core
	);

	register_taxonomy('tema', array('pauta'), $args);



	$labels = array
	(
		'name' => __('Situações','delibera'),
	    'singular_name' => __('Situação', 'delibera'),
		'search_items' => __('Procurar por Situação','delibera'),
		'all_items' => __('Todas as Situações','delibera'),
		'parent_item' => null,
		'parent_item_colon' => null,
		'edit_item' => __('Editar Situação','delibera'),
		'update_item' => __('Atualizar uma Situação','delibera'),
		'add_new_item' => __('Adicionar Nova Situação','delibera'),
	    'add_new' => __('Adicionar Nova', 'delibera'),
	    'new_item_name' => __('Nova Situação','delibera'),
	    'view_item' => __('Visualizar Situação','delibera'),
	    'not_found' =>  __('Nenhuma Situação localizado','delibera'),
	    'not_found_in_trash' => __('Nenhuma Situação localizada na lixeira','delibera'),
	    'menu_name' => __('Situações','delibera')
	);

	$args = array
	(
		'label' => __('Situações','delibera'),
		'labels' => $labels,
		'public' => false,
		'show_in_nav_menus' => true, // Public
		//'show_ui' => true, // Public
		'hierarchical' => false//,
		//'update_count_callback' => '', //Contar objetos associados
		//'rewrite' => '', //
		//'query_var' => '',
		//'_builtin' => '' // Core
	);

	register_taxonomy('situacao', array('pauta'), $args);

	// Se precisar trocar os nomes dos terms denovo
	/*$term = get_term_by('slug', 'comresolucao', 'situacao');
	wp_update_term($term->term_id, 'situacao', array('name' => 'Resolução'));
	$term = get_term_by('slug', 'emvotacao', 'situacao');
	wp_update_term($term->term_id, 'situacao', array('name' => 'Regime de Votação'));
	$term = get_term_by('slug', 'discussao', 'situacao');
	wp_update_term($term->term_id, 'situacao', array('name' => 'Pauta em discussão'));
	$term = get_term_by('slug', 'validacao', 'situacao');
	wp_update_term($term->term_id, 'situacao', array('name' => 'Proposta de Pauta'));
	$term = get_term_by('slug', 'naovalidada', 'situacao');
	wp_update_term($term->term_id, 'situacao', array('name' => 'Pauta Recusada'));*/

	$opt = delibera_get_config();

	if(taxonomy_exists('situacao'))
	{
		if(term_exists('comresolucao', 'situacao', null) == false)
		{
			delibera_insert_term('Resolução', 'situacao', array(
					'description'=> 'Pauta com resoluções aprovadas',
					'slug' => 'comresolucao',
				),
				array(
					'qtrans_term_pt' => 'Resolução',
					'qtrans_term_en' => 'Resolution',
					'qtrans_term_es' => 'Resolución',
				)
			);
		}
		if(term_exists('emvotacao', 'situacao', null) == false)
		{
			delibera_insert_term('Regime de Votação', 'situacao', array(
					'description'=> 'Pauta com encaminhamentos em Votacao',
					'slug' => 'emvotacao',
				),
				array(
					'qtrans_term_pt' => 'Regime de Votação',
					'qtrans_term_en' => 'Voting',
					'qtrans_term_es' => 'Sistema de Votación',
				)
			);
		}
		if(isset($opt['relatoria']) && $opt['relatoria'] == 'S')
		{
			if($opt['eleicao_relator'] == 'S')
			{
				if(term_exists('eleicaoredator', 'situacao', null) == false)
				{
					delibera_insert_term('Regime de Votação de Relator', 'situacao', array(
							'description'=> 'Pauta em Eleição de Relator',
							'slug' => 'eleicaoredator',
						),
						array(
							'qtrans_term_pt' => 'Regime de Votação de Relator',
							'qtrans_term_en' => 'Election of Rapporteur',
							'qtrans_term_es' => 'Elección del Relator',
						)
					);
				}
			}

			if(term_exists('relatoria', 'situacao', null) == false)
			{
				delibera_insert_term('Relatoria', 'situacao', array(
						'description'=> 'Pauta com encaminhamentos em Relatoria',
						'slug' => 'relatoria',
					),
					array(
						'qtrans_term_pt' => 'Relatoria',
						'qtrans_term_en' => 'Rapporteur',
						'qtrans_term_es' => 'Relator',
					)
				);
				}
		}
		if(term_exists('discussao', 'situacao', null) == false)
		{
			delibera_insert_term('Pauta em discussão', 'situacao', array(
					'description'=> 'Pauta em Discussão',
					'slug' => 'discussao',
				),
				array(
					'qtrans_term_pt' => 'Pauta em discussão',
					'qtrans_term_en' => 'Agenda en discusión',
					'qtrans_term_es' => 'Topic under discussion',
				)
			);
		}
		if(isset($opt['validacao']) && $opt['validacao'] == 'S')
		{
			if(term_exists('validacao', 'situacao', null) == false)
			{
				delibera_insert_term('Proposta de Pauta', 'situacao', array(
						'description'=> 'Pauta em Validação',
						'slug' => 'validacao',
					),
					array(
						'qtrans_term_pt' => 'Proposta de Pauta',
						'qtrans_term_en' => 'Proposed Topic',
						'qtrans_term_es' => 'Agenda Propuesta',
					)
				);
			}
			if(term_exists('naovalidada', 'situacao', null) == false)
			{
				delibera_insert_term('Pauta Recusada', 'situacao', array(
						'description'=> 'Pauta não Validação',
						'slug' => 'naovalidada',
					),
					array(
						'qtrans_term_pt' => 'Pauta Recusada',
						'qtrans_term_en' => 'Rejected Topic',
						'qtrans_term_es' => 'Agenda Rechazada',
					)
				);
			}
		}
	}

	if(file_exists(__DIR__.DIRECTORY_SEPARATOR.'delibera_taxs.php'))
	{
		require_once __DIR__.DIRECTORY_SEPARATOR.'delibera_taxs.php';
	}

}


function delibera_init()
{
	add_action('admin_menu', 'delibera_config_menu');

	delibera_Add_custom_Post();

	delibera_Add_custom_taxonomy();

	global $delibera_comments_padrao;
	$delibera_comments_padrao = false;

}
add_action('init','delibera_init');

// Scripts

function delibera_scripts()
{
	global $post;

	if (is_pauta()) {
		wp_enqueue_script('jquery-expander', WP_CONTENT_URL.'/plugins/delibera/js/jquery.expander.js', array('jquery'));
		wp_enqueue_script('delibera', WP_CONTENT_URL.'/plugins/delibera/js/scripts.js', array('jquery-expander'));
		wp_enqueue_script('delibera-seguir', WP_CONTENT_URL . '/plugins/delibera/js/delibera_seguir.js', array('delibera'));
		wp_enqueue_script('delibera-concordar', WP_CONTENT_URL . '/plugins/delibera/js/delibera_concordar.js', array('delibera'));

		$situation = delibera_get_situacao($post->ID);

		$data = array(
			'post_id' => $post->ID,
			'ajax_url' => admin_url('admin-ajax.php'),
		);

		if (is_object($situation)) {
			$data['situation'] = $situation->slug;
		}

		wp_localize_script('delibera', 'delibera', $data);
	}
}
add_action( 'wp_print_scripts', 'delibera_scripts' );

/**
 *
 * Se tiver estilos customizados, ta aí a dica...
 *
function delibera_print_styles()
{

}
add_action('wp_print_styles', 'delibera_print_styles');*/

function delibera_print_styles()
{
	if (is_pauta()) {
		wp_enqueue_style('jquery-ui-custom', plugins_url() . '/delibera/css/jquery-ui-1.9.2.custom.min.css');
	}

	wp_enqueue_style('delibera_style', WP_CONTENT_URL.'/plugins/delibera/css/delibera.css');
}
add_action('admin_print_styles', 'delibera_print_styles');

function delibera_admin_scripts()
{
	if(is_pauta())
	{
		wp_enqueue_script('jquery-ui-datepicker-ptbr', WP_CONTENT_URL.'/plugins/delibera/js/jquery.ui.datepicker-pt-BR.js', array('jquery-ui-datepicker'));
		wp_enqueue_script('delibera-admin',WP_CONTENT_URL.'/plugins/delibera/js/admin_scripts.js', array( 'jquery-ui-datepicker-ptbr'));
	}

	if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'delibera-notifications')
	{
		wp_enqueue_script('delibera-admin-notifica',WP_CONTENT_URL.'/plugins/delibera/js/admin_notifica_scripts.js', array('jquery'));
	}
}
add_action( 'admin_print_scripts', 'delibera_admin_scripts' );

// Fim Scripts

function delibera_footer() {

    echo '<div id="mensagem-confirma-voto" style="display:none;"><p>'.__('Sua contribuição foi registrada no sistema','delibera').'</p></div>';

}
add_action('wp_footer', 'delibera_footer');


function delibera_loaded() {
	// load plugin translations
	load_plugin_textdomain('delibera', false, dirname(plugin_basename( __FILE__ )).'/lang');
}
add_action('plugins_loaded','delibera_loaded');

$conf = delibera_get_config();
if(array_key_exists('plan_restriction', $conf) && $conf['plan_restriction'] == 'S')
{
	require_once __DIR__.DIRECTORY_SEPARATOR.'delibera_plan.php';
}

/*
 * Get page by slug
 */
function get_page_by_slug($page_slug, $output = OBJECT, $post_type = 'page' ) {
	global $wpdb;
	$page = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type= %s", $page_slug, $post_type ) );
	if ( $page )
		return get_page($page, $output);
	return null;
}

/**
 * Retorna a lista de idiomas disponível. Se o plugin
 * qtrans estiver habilitado retorna os idiomas dele, se
 * não usa o idioma definido no wp-config.php
 *
 * @return array
 */
function delibera_get_available_languages() {
    $langs = array(get_locale());

    if(function_exists('qtrans_enableLanguage'))
    {
        global $q_config;
        $langs = $q_config['enabled_languages'];
    }

    return $langs;
}