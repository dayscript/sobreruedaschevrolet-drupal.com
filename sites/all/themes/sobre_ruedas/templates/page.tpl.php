<!--.page -->
<div role="document" class="page">

  <!--.l-header -->
  <div class="container-header">
  <header role="banner" class="l-header">

    <?php if (!empty($page['header'])): ?>
      <!--.l-header-region -->

      <section class="l-header-region row">
        <div class="columns">
          <?php print render($page['header']); ?>

        </div>
      </section>

      <!--/.l-header-region -->
    <?php endif; ?>

  </header>
    </div>
  <!--/.l-header -->

    <?php if (!empty($page['featured'])): ?>
      <!--.l-featured -->
      <section class="l-featured row">
        <div class="columns">
          <?php print render($page['featured']); ?>
        </div>
      </section>
      <!--/.l-featured -->
    <?php endif; ?>


  <?php if ($messages && !$zurb_foundation_messages_modal): ?>
    <!--.l-messages -->
    <section class="l-messages row">
      <div class="columns">
        <?php if ($messages): print $messages; endif; ?>
      </div>
    </section>
    <!--/.l-messages -->
  <?php endif; ?>

  <div class="container-help">
  <?php if (!empty($page['help'])): ?>
    <!--.l-help -->
    <section class="l-help row">
      <div class="columns">
        <?php print render($page['help']); ?>
      </div>
    </section>
    <!--/.l-help -->
  <?php endif; ?>
</div>
  <!--.l-main -->
  <div class="main-container">
  <main role="main" class="row l-main">
    <!-- .l-main region -->
    <div class="<?php print $main_grid; ?> main columns">
      <?php if (!empty($page['highlighted'])): ?>
        <div class="highlight panel callout">
          <?php print render($page['highlighted']); ?>
        </div>
      <?php endif; ?>

      <a id="main-content"></a>

      <?php if (!empty($tabs)): ?>
        <?php print render($tabs); ?>
        <?php if (!empty($tabs2)): print render($tabs2); endif; ?>
      <?php endif; ?>

      <?php if ($action_links): ?>
        <ul class="action-links">
          <?php print render($action_links); ?>
        </ul>
      <?php endif; ?>

      <?php print render($page['content']); ?>
    </div>
    <!--/.l-main region -->

    <?php if (!empty($page['sidebar_first'])): ?>
      <aside role="complementary" class="<?php print $sidebar_first_grid; ?> sidebar-first columns sidebar">
        <?php print render($page['sidebar_first']); ?>
      </aside>
    <?php endif; ?>

    <?php if (!empty($page['sidebar_second'])): ?>
      <aside role="complementary" class="<?php print $sidebar_sec_grid; ?> sidebar-second columns sidebar">
        <?php print render($page['sidebar_second']); ?>
      </aside>
    <?php endif; ?>
  </main>
  </div>
  <!--/.l-main -->

  <?php if (!empty($page['triptych_first']) || !empty($page['triptych_middle']) || !empty($page['triptych_last'])): ?>
    <!--.triptych-->
    <section class="l-triptych row">
      <div class="triptych-first medium-4 columns">
        <?php print render($page['triptych_first']); ?>
      </div>
      <div class="triptych-middle medium-4 columns">
        <?php print render($page['triptych_middle']); ?>
      </div>
      <div class="triptych-last medium-4 columns">
        <?php print render($page['triptych_last']); ?>
      </div>
    </section>
    <!--/.triptych -->
  <?php endif; ?>

  <?php if (!empty($page['footer_firstcolumn']) || !empty($page['footer_secondcolumn']) || !empty($page['footer_thirdcolumn']) || !empty($page['footer_fourthcolumn'])): ?>
    <!--.footer-columns -->

    <section class="row l-footer-columns">
      <hr>
      <?php if (!empty($page['footer_firstcolumn'])): ?>
        <div class="footer-first medium-3 columns">
          <?php print render($page['footer_firstcolumn']); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($page['footer_secondcolumn'])): ?>
        <div class="footer-second medium-3 columns">
          <?php print render($page['footer_secondcolumn']); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($page['footer_thirdcolumn'])): ?>
        <div class="footer-third medium-3 columns">
          <?php print render($page['footer_thirdcolumn']); ?>
        </div>
      <?php endif; ?>
      <?php if (!empty($page['footer_fourthcolumn'])): ?>
        <div class="footer-fourth medium-3 columns">
          <?php print render($page['footer_fourthcolumn']); ?>
        </div>
      <?php endif; ?>
    </section>
    <!--/.footer-columns-->
  <?php endif; ?>

  <!--.l-footer -->
  <footer class="l-footer row" role="contentinfo">
    <?php if (!empty($page['footer'])): ?>
      <div class="footer columns">
        <?php print render($page['footer']); ?>
      </div>
    <?php endif; ?>
  </footer>
  <!--/.l-footer -->

  <?php if ($messages && $zurb_foundation_messages_modal): print $messages; endif; ?>
</div>
<!--/.page -->
