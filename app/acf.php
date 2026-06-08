<?php

namespace App;

if (! function_exists('acf_add_local_field_group')) {
    return;
}

add_action('acf/init', function () {

    acf_add_local_field_group([
        'key'    => 'group_titulinis_page',
        'title'  => 'Titulinis puslapis',
        'fields' => [

            // ── HEROJAUS KARUSELĖ ─────────────────────────────
            [
                'key'    => 'field_home_hero_slides',
                'label'  => 'Herojaus skaidrės',
                'name'   => 'home_hero_slides',
                'type'   => 'repeater',
                'min'    => 1,
                'layout' => 'row',
                'sub_fields' => [
                    [
                        'key'           => 'field_hero_slide_image',
                        'label'         => 'Fono nuotrauka',
                        'name'          => 'hero_slide_image',
                        'type'          => 'image',
                        'return_format' => 'id',
                        'preview_size'  => 'medium',
                        'column_width'  => '20',
                    ],
                    [
                        'key'           => 'field_hero_slide_image_mobile',
                        'label'         => 'Fono nuotrauka (mobile)',
                        'name'          => 'hero_slide_image_mobile',
                        'type'          => 'image',
                        'return_format' => 'id',
                        'preview_size'  => 'thumbnail',
                        'instructions'  => 'Neprivaloma. Jei nepridėta - naudojama pagrindinė.',
                        'column_width'  => '20',
                    ],
                    [
                        'key'          => 'field_hero_slide_heading',
                        'label'        => 'Antraštė',
                        'name'         => 'hero_slide_heading',
                        'type'         => 'text',
                        'column_width' => '30',
                    ],
                    [
                        'key'          => 'field_hero_slide_text',
                        'label'        => 'Tekstas',
                        'name'         => 'hero_slide_text',
                        'type'         => 'textarea',
                        'rows'         => 2,
                        'column_width' => '20',
                    ],
                    [
                        'key'          => 'field_hero_slide_cta_url',
                        'label'        => 'Mygtuko nuoroda',
                        'name'         => 'hero_slide_cta_url',
                        'type'         => 'text',
                        'instructions' => 'URL arba inkaras, pvz. /kontaktai/ arba #mainForm-business',
                        'column_width' => '10',
                    ],
                ],
            ],
            [
                'key'           => 'field_home_hero_button_text',
                'label'         => 'Mygtuko tekstas',
                'name'          => 'home_hero_button_text',
                'type'          => 'text',
                'default_value' => 'Konsultacija',
                'instructions'  => 'Tekstas rodomas visose skaidrėse.',
            ],

            // ── PASLAUGOS ─────────────────────────────────────
            [
                'key'           => 'field_home_services_label',
                'label'         => 'Paslaugų žymė',
                'name'          => 'home_services_label',
                'type'          => 'text',
                'default_value' => 'SPECIALIZACIJA',
            ],
            [
                'key'   => 'field_home_services_heading',
                'label' => 'Paslaugų antraštė',
                'name'  => 'home_services_heading',
                'type'  => 'text',
            ],
            [
                'key'  => 'field_home_services_subtext',
                'label' => 'Paslaugų subtekstas',
                'name'  => 'home_services_subtext',
                'type'  => 'textarea',
                'rows'  => 2,
            ],
            [
                'key'    => 'field_home_services_items',
                'label'  => 'Paslaugos',
                'name'   => 'home_services_items',
                'type'   => 'repeater',
                'min'    => 1,
                'layout' => 'table',
                'sub_fields' => [
                    [
                        'key'           => 'field_service_icon',
                        'label'         => 'Ikona',
                        'name'          => 'service_icon',
                        'type'          => 'image',
                        'return_format' => 'id',
                        'preview_size'  => 'thumbnail',
                        'column_width'  => '15',
                    ],
                    [
                        'key'          => 'field_service_title',
                        'label'        => 'Pavadinimas',
                        'name'         => 'service_title',
                        'type'         => 'text',
                        'column_width' => '20',
                    ],
                    [
                        'key'          => 'field_service_description',
                        'label'        => 'Aprašymas',
                        'name'         => 'service_description',
                        'type'         => 'textarea',
                        'rows'         => 3,
                        'column_width' => '35',
                    ],
                    [
                        'key'          => 'field_service_link',
                        'label'        => 'Nuoroda',
                        'name'         => 'service_link',
                        'type'         => 'url',
                        'column_width' => '20',
                    ],
                    [
                        'key'           => 'field_service_featured',
                        'label'         => 'Paryškinti (violetinis)',
                        'name'          => 'service_featured',
                        'type'          => 'true_false',
                        'default_value' => 0,
                        'column_width'  => '10',
                    ],
                ],
            ],

            // ── STATISTIKA ────────────────────────────────────
            [
                'key'    => 'field_home_stats_items',
                'label'  => 'Statistikos rodikliai',
                'name'   => 'home_stats_items',
                'type'   => 'repeater',
                'min'    => 1,
                'layout' => 'table',
                'sub_fields' => [
                    [
                        'key'          => 'field_stat_label',
                        'label'        => 'Žymė',
                        'name'         => 'stat_label',
                        'type'         => 'text',
                        'column_width' => '30',
                    ],
                    [
                        'key'          => 'field_stat_number',
                        'label'        => 'Skaičius',
                        'name'         => 'stat_number',
                        'type'         => 'text',
                        'column_width' => '20',
                    ],
                    [
                        'key'          => 'field_stat_description',
                        'label'        => 'Aprašymas',
                        'name'         => 'stat_description',
                        'type'         => 'text',
                        'column_width' => '50',
                    ],
                ],
            ],

            // ── ENERGIJOS KAUPIKLIS (VIDEO) ───────────────────
            [
                'key'           => 'field_home_energy_label',
                'label'         => 'Energijos kaupiklio žymė',
                'name'          => 'home_energy_label',
                'type'          => 'text',
                'default_value' => 'ENERGIJOS KAUPIKLIS',
            ],
            [
                'key'   => 'field_home_energy_heading',
                'label' => 'Energijos kaupiklio antraštė',
                'name'  => 'home_energy_heading',
                'type'  => 'text',
            ],
            [
                'key'  => 'field_home_energy_description',
                'label' => 'Energijos kaupiklio aprašymas',
                'name'  => 'home_energy_description',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'    => 'field_home_energy_bullets',
                'label'  => 'Privalumų sąrašas',
                'name'   => 'home_energy_bullets',
                'type'   => 'repeater',
                'layout' => 'table',
                'sub_fields' => [
                    [
                        'key'   => 'field_energy_bullet_text',
                        'label' => 'Tekstas',
                        'name'  => 'energy_bullet_text',
                        'type'  => 'text',
                    ],
                ],
            ],
            [
                'key'          => 'field_home_energy_youtube_url',
                'label'        => 'YouTube vaizdo įrašo nuoroda',
                'name'         => 'home_energy_youtube_url',
                'type'         => 'url',
                'instructions' => 'Pvz.: https://www.youtube.com/watch?v=XXXXX',
            ],
            [
                'key'           => 'field_home_energy_thumbnail',
                'label'         => 'Vaizdo miniatiūra',
                'name'          => 'home_energy_thumbnail',
                'type'          => 'image',
                'return_format' => 'url',
                'instructions'  => 'Jei nepridėta, bus naudojama automatinė YouTube miniatiūra.',
            ],
            [
                'key'           => 'field_home_energy_partner_logo',
                'label'         => 'Partnerio logotipas (pvz. Sigenergy Gold)',
                'name'          => 'home_energy_partner_logo',
                'type'          => 'image',
                'return_format' => 'id',
            ],
            [
                'key'          => 'field_home_energy_partner_text',
                'label'        => 'Partnerio tekstas',
                'name'         => 'home_energy_partner_text',
                'type'         => 'textarea',
                'rows'         => 3,
                'instructions' => 'Rodomas šalia logotipo su vertikalia linija kairėje.',
            ],

            // ── VALSTYBĖS PARAMA ──────────────────────────────
            [
                'key'           => 'field_home_comp_label',
                'label'         => 'Paramos žymė',
                'name'          => 'home_comp_label',
                'type'          => 'text',
                'default_value' => 'VALSTYBĖS PARAMA',
            ],
            [
                'key'   => 'field_home_comp_heading',
                'label' => 'Paramos antraštė',
                'name'  => 'home_comp_heading',
                'type'  => 'text',
            ],
            [
                'key'  => 'field_home_comp_subtext',
                'label' => 'Paramos subtekstas',
                'name'  => 'home_comp_subtext',
                'type'  => 'text',
            ],
            [
                'key'           => 'field_home_comp_card1_image',
                'label'         => '1 kortelė - nuotrauka',
                'name'          => 'home_comp_card1_image',
                'type'          => 'image',
                'return_format' => 'url',
            ],
            [
                'key'           => 'field_home_comp_card1_badge',
                'label'         => '1 kortelė - žymė',
                'name'          => 'home_comp_card1_badge',
                'type'          => 'text',
                'default_value' => 'Susigrąžinkit iki 1190 EUR',
            ],
            [
                'key'   => 'field_home_comp_card1_title',
                'label' => '1 kortelė - pavadinimas',
                'name'  => 'home_comp_card1_title',
                'type'  => 'text',
            ],
            [
                'key'  => 'field_home_comp_card1_desc',
                'label' => '1 kortelė - aprašymas',
                'name'  => 'home_comp_card1_desc',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'   => 'field_home_comp_card1_url',
                'label' => '1 kortelė - nuoroda',
                'name'  => 'home_comp_card1_url',
                'type'  => 'url',
            ],
            [
                'key'           => 'field_home_comp_card2_image',
                'label'         => '2 kortelė - nuotrauka',
                'name'          => 'home_comp_card2_image',
                'type'          => 'image',
                'return_format' => 'url',
            ],
            [
                'key'           => 'field_home_comp_card2_badge',
                'label'         => '2 kortelė - žymė',
                'name'          => 'home_comp_card2_badge',
                'type'          => 'text',
                'default_value' => 'Susigrąžinkit iki 2250 EUR',
            ],
            [
                'key'   => 'field_home_comp_card2_title',
                'label' => '2 kortelė - pavadinimas',
                'name'  => 'home_comp_card2_title',
                'type'  => 'text',
            ],
            [
                'key'  => 'field_home_comp_card2_desc',
                'label' => '2 kortelė - aprašymas',
                'name'  => 'home_comp_card2_desc',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'   => 'field_home_comp_card2_url',
                'label' => '2 kortelė - nuoroda',
                'name'  => 'home_comp_card2_url',
                'type'  => 'url',
            ],

            // ── MUMIS PASITIKI ────────────────────────────────
            [
                'key'           => 'field_home_clients_heading',
                'label'         => 'Klientų antraštė',
                'name'          => 'home_clients_heading',
                'type'          => 'text',
                'default_value' => 'Mumis pasitiki',
            ],
            [
                'key'  => 'field_home_clients_subtext',
                'label' => 'Klientų subtekstas',
                'name'  => 'home_clients_subtext',
                'type'  => 'textarea',
                'rows'  => 2,
            ],
            [
                'key'    => 'field_home_clients_logos',
                'label'  => 'Klientų logotipai',
                'name'   => 'home_clients_logos',
                'type'   => 'repeater',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key'           => 'field_client_logo',
                        'label'         => 'Logotipas',
                        'name'          => 'client_logo',
                        'type'          => 'image',
                        'return_format' => 'id',
                        'preview_size'  => 'thumbnail',
                    ],
                ],
            ],

            // ── FORMA ─────────────────────────────────────────
            [
                'key'           => 'field_home_form_heading',
                'label'         => 'Formos antraštė',
                'name'          => 'home_form_heading',
                'type'          => 'text',
                'default_value' => 'Gaukite individualų pasiūlymą!',
            ],
            [
                'key'  => 'field_home_form_description',
                'label' => 'Formos aprašymas',
                'name'  => 'home_form_description',
                'type'  => 'textarea',
                'rows'  => 5,
            ],
            [
                'key'           => 'field_home_form_phone',
                'label'         => 'Telefonas',
                'name'          => 'home_form_phone',
                'type'          => 'text',
                'default_value' => '+370 600 61009',
            ],
            [
                'key'           => 'field_home_form_email',
                'label'         => 'El. paštas',
                'name'          => 'home_form_email',
                'type'          => 'email',
                'default_value' => 'info@reenpro.lt',
            ],

            // ── PARTNERIŲ LOGOTIPAI ───────────────────────────
            [
                'key'    => 'field_home_partners_logos',
                'label'  => 'Partnerių logotipai (apačia)',
                'name'   => 'home_partners_logos',
                'type'   => 'repeater',
                'layout' => 'block',
                'sub_fields' => [
                    [
                        'key'           => 'field_partner_logo',
                        'label'         => 'Logotipas',
                        'name'          => 'partner_logo',
                        'type'          => 'image',
                        'return_format' => 'id',
                        'preview_size'  => 'thumbnail',
                    ],
                ],
            ],
        ],
        'location' => [[
            ['param' => 'page_type', 'operator' => '==', 'value' => 'front_page'],
        ]],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
        'active'     => true,
    ]);
});
