<div class="container-fluid">
  <div class="row page-titles">
      <div class="col-md-5 align-self-center">
          <h4 class="text-themecolor">Dashboard</h4>
      </div>
      <div class="col-md-7 align-self-center text-right">
          <div class="d-flex justify-content-end align-items-center">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item active">Dashboard</li>
              </ol>
          </div>
      </div>
  </div>

  <div class="card-group">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <h3><i class="icon-screen-desktop"></i></h3>
                            <p class="text-muted">USERS</p>
                        </div>
                        <div class="ml-auto">
                            <h2 class="counter text-primary" id="count_user">0</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <h3><i class="icon-note"></i></h3>
                            <p class="text-muted">LOG</p>
                        </div>
                        <div class="ml-auto">
                            <h2 class="counter text-cyan" id="count_log">0</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
      <div class="card">
          <div class="card-body">
              <div class="d-flex m-b-40 align-items-center no-block">
                  <h5 class="card-title ">User Chart</h5>
              </div>
              <canvas id="userChart" height="263"></canvas>
          </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
          <div class="card-body">
              <div class="d-flex m-b-40 align-items-center no-block">
                  <h5 class="card-title ">Log Chart</h5>
              </div>
              <canvas id="logChart" height="120"></canvas>
          </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function(){
    var session = localStorage.getItem('sipb');
    var auth = JSON.parse(session);

    var userChart = new Chart(document.getElementById('userChart').getContext('2d'),{
      type : 'pie',
      data : {
        labels : [],
        datasets: [{
          data : [],
          backgroundColor: [
            "#17a2b8",
            "#28a745",
            'red',
            'yellow'
          ]
        }],
      },

      options : {
        legend : {
          display : true,
        },
        responsive : true,
        tooltips: {
          enabled: true,
        }
      }
    });

      var logChart = new Chart(document.getElementById('logChart').getContext('2d'),{
      type: 'bar',
      data: {
        labels:[
          'Jan',
          'Feb',
          'Mar',
          'Apr',
          'May',
          'Jun',
          'Jul',
          'Aug',
          'Sep',
          'Oct',
          'Nov',
          'Dec',
        ],
        datasets:[{
          label: 'Log by month',
          data: [],
          borderColor: "rgba(0, 176, 228, 0.75)",
          backgroundColor: "rgb(0, 176, 228)",
          pointBorderColor: "rgba(0, 176, 228, 0)",
          pointBackgroundColor: "rgba(0, 176, 228, 0.9)",
          pointBorderWidth: 1,
        }],
      },
      options:{
        responsive : true,
        legend : {
          display : true,
        },
      },
    });

    $.ajax({
      url: `<?= base_url('api/log/statistic/') ?>${auth.token}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){
        $.each(response.data.log_by_month, function(k, v){
          logChart.data.datasets[0].data.push(v);
        });
        $('#count_log').text(response.data.total_log);
        logChart.update();
      }
    });

    $.ajax({
      url: `<?= base_url('api/user/statistic/') ?>${auth.token}`,
      type: 'GET',
      dataType: 'JSON',
      success: function(response){
        var total = 0;
        $.each(response.data, function(k, v){
          userChart.data.labels.push(v.level);
          userChart.data.datasets[0].data.push(v.jml_user);

          total += parseInt(v.jml_user);
        });
        $('#count_user').text(total);
        userChart.update();
      }
    })
  })
  
</script>
