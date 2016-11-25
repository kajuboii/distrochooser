<div class="modal fade" id="about" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"> {{ text('about') }}</h4>
      </div>
      <div class="modal-body">
        <p v-html="text('aboutText')"></p>
        <h3>{{ text('installedDistros') }}</h3>
        <ul>
          <li v-for="distro in ldc.distributions">
            <a href="{{distro.Website}}">{{distro.Name}}</a>
          </li>
        </ul>
        <h3>{{ text('stats') }}</h3>
         <canvas id="testCountCanvas" width="598" height="400"></canvas>
        <br>
        <script type="text/javascript">

        </script>
        <h4>{{ text('uses') }}</h4>
        <ul>
          <li><a href="http://getbootstrap.com/">Bootstrap</a></li>
          <li><a href="https://bootswatch.com/lumen/">Bootswatch Theme Lumen</a></li>
          <li><a href="https://vuejs.org">vue.js</a></li>
          <li><a href="https://jquery.com/">jQuery</a></li>
          <li><a href="http://www.deviantart.com/art/Tondo-F-Icon-Set-OS-327759704">Tux Icon von P3T3B3</a></li>
          <li><a href="http://cmalek.de">Phis</a> (Design)</li>
          <li><a href="https://dribbble.com/shots/1211759-Free-195-Flat-Flags">Flat flag icons -  Muharrem Şenyıl</a></li>
          <li>Lenny (Manjaro Screenshots)</li>
          <li><a href="https://prrashi.github.io/rateYo/">rateYo</a></li>
          <li><a href="http://www.chartjs.org/">Chart.js</a></li>
        </ul>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
