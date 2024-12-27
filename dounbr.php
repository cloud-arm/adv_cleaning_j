<style>
svg {
	position: fixed;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
	height: 150px;
	width: 150px;
}
.loader{
 background-color:rgba(0,0,0,0.8);
}
        </style>
<div class="container-up loader d-none" id="loader_svg">
<svg viewBox="0 0 100 100">
	<g fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="6">
		<!-- left line -->
		<path d="M 21 40 V 59">
			<animateTransform
      attributeName="transform"
      attributeType="XML"
      type="rotate"
      values="0 21 59; 180 21 59"
      dur="2s"
      repeatCount="indefinite" />
		</path>
		<!-- right line -->
		<path d="M 79 40 V 59">
			<animateTransform
      attributeName="transform"
      attributeType="XML"
      type="rotate"
      values="0 79 59; -180 79 59"
      dur="2s"
      repeatCount="indefinite" />
		</path>
		<!-- top line -->
		<path d="M 50 21 V 40">
			<animate
      attributeName="d"
      values="M 50 21 V 40; M 50 59 V 40"
      dur="2s"
      repeatCount="indefinite" />
		</path>
		<!-- btm line -->
		<path d="M 50 60 V 79">
			<animate
      attributeName="d"
      values="M 50 60 V 79; M 50 98 V 79"
      dur="2s"
      repeatCount="indefinite" />
		</path>
		<!-- top box -->
		<path d="M 50 21 L 79 40 L 50 60 L 21 40 Z">
		<animate
      attributeName="stroke"
      values="rgba(255,255,255,1); rgba(100,100,100,0)"
      dur="2s"
      repeatCount="indefinite" />
		</path>
		<!-- mid box -->
		<path d="M 50 40 L 79 59 L 50 79 L 21 59 Z"/>
		<!-- btm box -->
		<path d="M 50 59 L 79 78 L 50 98 L 21 78 Z">
		<animate
      attributeName="stroke"
      values="rgba(100,100,100,0); rgba(255,255,255,1)"
      dur="2s"
      repeatCount="indefinite" />
		</path>
		<animateTransform
      attributeName="transform"
      attributeType="XML"
      type="translate"
      values="0 0; 0 -19"
      dur="2s"
      repeatCount="indefinite" />
	</g>
</svg>
</div>
<script>
  function clikup() {
    document.getElementById('loader_svg').classList.remove('d-none');
  }

</script>
<footer class="main-footer">
  <div class="pull-right hidden-xs">
    <b>Version</b> 2.0
  </div>
  <strong>Copyright &copy; <?php echo date('Y'); ?> . All Right Reserved By <a href="http://cloudarmsoft.com">CLOUD ARM</a>.</strong>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Create the tabs -->
  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">
    <!-- Home tab content -->
    <div class="tab-pane" id="control-sidebar-home-tab">
      <h3 class="control-sidebar-heading">Recent Activity</h3>
      <ul class="control-sidebar-menu">
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

              <p>Will be 23 on April 24th</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-user bg-yellow"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

              <p>New phone +1(800)555-1234</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

              <p>nora@example.com</p>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <i class="menu-icon fa fa-file-code-o bg-green"></i>

            <div class="menu-info">
              <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

              <p>Execution time 5 seconds</p>
            </div>
          </a>
        </li>
      </ul>
      <!-- /.control-sidebar-menu -->

      <h3 class="control-sidebar-heading">Tasks Progress</h3>
      <ul class="control-sidebar-menu">
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Custom Template Design
              <span class="label label-danger pull-right">70%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Update Resume
              <span class="label label-success pull-right">95%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-success" style="width: 95%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Laravel Integration
              <span class="label label-warning pull-right">50%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
            </div>
          </a>
        </li>
        <li>
          <a href="javascript:void(0)">
            <h4 class="control-sidebar-subheading">
              Back End Framework
              <span class="label label-primary pull-right">68%</span>
            </h4>

            <div class="progress progress-xxs">
              <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
            </div>
          </a>
        </li>
      </ul>
      <!-- /.control-sidebar-menu -->

    </div>
    <!-- /.tab-pane -->
    <!-- Stats tab content -->
    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
    <!-- /.tab-pane -->
    <!-- Settings tab content -->
    <div class="tab-pane" id="control-sidebar-settings-tab">
      <form method="post">
        <h3 class="control-sidebar-heading">General Settings</h3>

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Report panel usage
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Some information about this general settings option
          </p>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Allow mail redirect
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Other sets of options are available
          </p>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Expose author name in posts
            <input type="checkbox" class="pull-right" checked>
          </label>

          <p>
            Allow the user to show his name in blog posts
          </p>
        </div>
        <!-- /.form-group -->

        <h3 class="control-sidebar-heading">Chat Settings</h3>

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Show me as online
            <input type="checkbox" class="pull-right" checked>
          </label>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Turn off notifications
            <input type="checkbox" class="pull-right">
          </label>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Delete chat history
            <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
          </label>
        </div>
        <!-- /.form-group -->
      </form>
    </div>
    <!-- /.tab-pane -->
  </div>
</aside>