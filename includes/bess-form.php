<?php if (get_field('bess_contact_form', 'options')) { ?>
<!-- TODO: REMOVE LATER -->
<div id="mainForm" style="position: absolute; visibility: hidden;"></div>
<!-- ------------------ -->
  <div class="form-section bg-purple pt-50 pt-md-80 pb-50 pb-md-80" id="bessForm">
    <div class="container" id="versloklientas" >
      <div class="row align-items-center justify-content-center" id="privatusklientas">
        <div class="col-12  col-lg-5 col-xl-4 offset-xl-1 mb-30 mb-lg-0">
          <?php if (get_field('bess_contact_title', 'options')) { ?>
            <div class="form-section__heading mb-20 mb-md-60 c-white h3">
              <?php the_field('bess_contact_title', 'options'); ?>
            </div>
          <?php } ?>
          <?php if (get_field('bess_contact_text', 'options')) { ?>
            <div class="form-section__text mb-20 c-white">
              <?php the_field('bess_contact_text', 'options'); ?>
            </div>
          <?php } ?>
          <?php if (have_rows('global_contacts', 'options')) { ?>
            <div class="">
              <?php while (have_rows('global_contacts', 'options')) { ?>
                <?php the_row(); ?>
                <div
                  class="footer-info__details footer-info__details--black footer-info__details--<?php echo get_sub_field('info_type')['value'] ?> <?php echo get_sub_field('display') ? 'd-none' : '' ?>">
                  <?php the_sub_field('info', 'options'); ?>
                </div>
              <?php } ?>
            </div>
          <?php } ?>
        </div>
        <div class="col-12  col-lg-6  col-xl-6">


          <div class="contact-form mb-30" >
            <h3 class="mb-40 mb-lg-50 contact-form__heading">
              <?php if (get_field('bess_contact_heading_main', 'options')) { ?>
                <?php the_field('bess_contact_heading_main', 'options'); ?>
              <?php } else { ?>
                Užpildyk užklausą
              <?php } ?>
            </h3>
            <div class="contact-tabs mb-10">
              <div id="tabList">
                <div class="contact-tabs__list mb-15">
                  <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <?php if (get_field('bess_contact_form', 'options')) { ?>
                      <li class="flex-shrink-0">
                        <a class="active"
                           id="bess-heading-personal"
                           data-toggle="tab"
                           href="#bess-tab-personal"
                           role="tab"
                           aria-controls="bess-tab-personal"
                           aria-selected="true">
                          <?php if (get_field('bess_contact_form_tab_personal', 'options')) { ?>
                            <?php the_field('bess_contact_form_tab_personal', 'options'); ?>
                            <?php } else { ?>
                            Privatus klientas
                          <?php } ?>
                        </a>
                      </li>
                    <?php } ?>
                    <?php if (get_field('bess_contact_form_business', 'options')) { ?>
                      <li class="flex-shrink-0">
                        <a class=""
                           id="bess-heading-business"
                           data-toggle="tab"
                           href="#bess-tab-business"
                           role="tab"
                           aria-controls="bess-tab-business"
                           aria-selected="true">
                          <?php if (get_field('bess_contact_form_tab_business', 'options')) { ?>
                            <?php the_field('bess_contact_form_tab_business', 'options'); ?>
                          <?php } else { ?>
                            Verslo klientas
                          <?php } ?>

                        </a>
                      </li>
                    <?php } ?>
                  </ul>
                </div>
              </div>
            </div>
            <div class="contact-tabs">
              <div id="tabAnswer">
                <div class="contact-tabs__content pb-50 pb-md-0" id="myTabContent">
                  <?php if (get_field('bess_contact_form', 'options')) { ?>

                    <div class="tab-pane fade show active"
                         id="bess-tab-personal"
                         role="tabpanel"
                         aria-labelledby="bess-heading-personal">
                      <?php echo do_shortcode(get_field('bess_contact_form', 'options')) ?>
                    </div>
                  <?php } ?>
                  <?php if (get_field('bess_contact_form_business', 'options')) { ?>

                    <div class="tab-pane fade"
                         id="bess-tab-business"
                         role="tabpanel"
                         aria-labelledby="bess-heading-business">
                      <?php echo do_shortcode(get_field('bess_contact_form_business', 'options')) ?>
                    </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
