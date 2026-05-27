<?php if (have_rows('faq')) {
  $i = 1; ?>
  <div class="container">
    <div class="row justify-content-center mt-50 mt-md-120 mb-100 mb-md-155">
      <?php if (get_field('faq_heading')) { ?>
        <div class="col-12 col-md-10 col-xl-7 text-center">
          <h3 class="mb-40 mb-md-80"><?php the_field('faq_heading'); ?></h3>
        </div>
      <?php } ?>
      <div class="col-12 col-md-10 col-xl-7">
        <div id="faq-accordion" class="">
          <?php while (have_rows('faq')) { ?>
            <?php the_row(); ?>
            <div class="faq-card"
                 itemscope
                 itemprop="mainEntity"
                 itemtype="https://schema.org/Question">
              <div id="question-<?php echo $i; ?>">
                <!--                  --><?php //echo $i == 1 ? '' : 'collapsed' ?>
                <div class="faq-card__heading fw-bold faq-card__heading-icon collapsed "
                     data-toggle="collapse"
                     data-target="#collapse-<?php echo $i; ?>"
                     aria-expanded="true"
                     aria-controls="collapse-<?php echo $i; ?>"
                     itemprop="name">
                  <?php the_sub_field('heading'); ?>
                </div>
              </div>
              <div id="collapse-<?php echo $i; ?>"
                   class="collapse"
                   aria-labelledby="question-<?php echo $i; ?>"
                   data-parent="#faq-accordion"
                   itemscope itemprop="acceptedAnswer"
                   itemtype="https://schema.org/Answer">
                <div class="faq-card__content faq-card__content--link"
                     itemprop="text">
                  <?php the_sub_field('text'); ?>
                </div>
              </div>
            </div>
            <?php $i++;
          } ?>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
