<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!-- start: content -->
            <div id="content">
                <div class="col-md-12" style="padding:20px;">
                    <div class="col-md-12 padding-0">
                        <div class="col-md-8 padding-0">
                            <div class="col-md-12 padding-0">
                                <div class="col-md-6">
                                    <div class="panel box-v1">
                                      <div class="panel-heading bg-white border-none">
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                                          <h4 class="text-left">Jumlah Anime</h4>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                           <h4>
                                           <span class="icon-user icons icon text-right"></span>
                                           </h4>
                                        </div>
                                      </div>
                                      <div class="panel-body text-center">
                                        <h1><?php echo $count_anime ?></h1>
                                        <p>Anime</p>
                                        <hr/>
                                      </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel box-v1">
                                      <div class="panel-heading bg-white border-none">
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-left padding-0">
                                          <h4 class="text-left">Total Episode</h4>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-6 text-right">
                                           <h4>
                                           <span class="icon-basket-loaded icons icon text-right"></span>
                                           </h4>
                                        </div>
                                      </div>
                                      <div class="panel-body text-center">
                                        <h1><?php echo $count_episode ?></h1>
                                        <p>Episodes</p>
                                        <hr/>
                                      </div>
                                    </div>
                                </div>
                            </div>
                    </div>

                  <div class="col-md-12 card-wrap padding-0">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-body">
                            <legend>Daftar Anime</legend>
                              <table id="animes" class="table table-stripped">
                              <thead>
                                <tr>
                                  <th>#ID</th>
                                  <th>Judul Anime</th>
                                  <th>Publikasi Anime</th>
                                  <th>Total Episode</th>
                                  <th>Tanggal Rilis</th>
                                  <th>Status</th>
                                  <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($animes as $anime): ?>
                                  <tr>
                                    <td><?php echo $anime->idanime ?></td>
                                    <td><?php echo $anime->title_anime ?></td>
                                    <td><?php echo $anime->date_published ?></td>
                                    <td><?php echo $anime->max_episodes ?></td>
                                    <td><?php echo date("M, d Y",$anime->created_date) ?></td>
                                    <td><?php echo $anime->status ?></td>
                                    <td>
                                      <a class="btn btn-success" href="<?php echo site_url('dashboard/animes/edit/'.$anime->idanime.'/') ?>"><i class="fa fa-edit"></i></a>
                                      <a class="btn btn-danger" href="<?php echo site_url('dashboard/animes/delete/'.$anime->idanime.'/') ?>"><i class="fa fa-trash"></i></a>
                                    </td>
                                  </tr>
                                <?php endforeach; ?>
                                </tbody>
                              </table>
                            </div>
                        </div>
                    </div>

                    <script type="text/javascript">
                    $(document).ready(function()
                    {
                      $("#animes").DataTable();
                    });
                    </script>

                    <div class="col-md-12">
                        <div class="panel">
                            <div class="panel-body">
                            <legend>Daftar Link Episodes</legend>
                              <div class="pull-right">
                                <form>
                                  <input type="search" id="title_episode" name="q" placeholder="Search anime..." class="form-control"/> 
                                </form>
                              </div>
                              <table class="table table-stripped">
                                <thead>
                                <tr>
                                  <th>#ID</th>
                                  <th>Judul Anime</th>
                                  <th>Episode</th>
                                  <th>Sumber Video</th>
                                  <th>Tanggal Rilis</th>
                                </tr>
                                </thead>
                                <tbody  id="episodes">
                                  
                                </tbody>
                                <div id="paging-episode" class="pagination"></div>
                              </table>
                            </div>
                        </div>
                    </div>
                </div>
      		  </div>
          <!-- end: content -->

          <script>
      $("#paging-episode").paging(<?php echo $count_anime ?>, {
        format: '< nnncnnn >',
        perpage: 15,
        onSelect: function (page) {
          // add code which gets executed when user selects a page
          var dataS = "start="+ this.slice[0] + "&end="+ this.slice[1] + "&page=" + page;
          $.ajax({
            url: "<?php echo base_url().'dashboard/animes/listepisode/' ?>",
            data: dataS,
            type: 'POST',
            beforeSend:function(){
              $("#episodes").html('<center><i class="fa fa-spinner fa-spin fa-4x"></i></center');
            },
            success:function(data){
              $("#episodes").html(data);
            },
            error:function(data){
              $("#episodes").html("Try to load but return with error code : "+data.txtStatus);
            }
          })
        },
        onFormat: function (type) {
          switch (type) {
          case 'block': // n and c
            if(this.value != this.page)
              return '<li><a href="#'+ this.value +'" id="'+ this.value +'">' + this.value + '</a></li>';
            else
              return '<li class="active"><a href="#'+ this.value +'" id="'+ this.value +'">' + this.value + '</a></li>';
          case 'next': // >
            if(this.active)
              return '<li><a href="#'+ this.value +'" id="'+ this.value +'">Next</a></li>';
            else
              return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'">Next</a></li>';
          case 'prev': // <
            if(this.active)
              return '<li><a href="#'+ this.value +'" id="'+ this.value +'">Previous</a></li>';
            else
              return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'">Previous</a></li>';
          case 'first': // [
            if(this.active)
              return '<li><a href="#'+ this.value +'" id="'+ this.value +'">First</a></li>';
            else
              return '<li class="disabled"><a href="#'+ this.value +'" id="'+ this.value +'">First</a></li>';
          case 'last': // ]
            if(this.active)
              return '<li><a href="#'+ this.value+ '" id="'+ this.value +'">Last</a></li>';
            else
              return '<li class="disabled"><a href="#'+ this.value+ '" id="'+ this.value +'">Last</a></li>';
          }
        }
      });
      </script>

      <script type="text/javascript">
        var MIN_LENGTH = 3;
        $( document ).ready(function() {
          $("#title_episode").keyup(function() {
            var keyword = $("#title_episode").val();
            if (keyword.length >= MIN_LENGTH) {
              $.get( "<?php echo base_url() ?>dashboard/animes/episodesearch/", { keyword: keyword } )
                .done(function( data ) {
                  $("#episodes").html(data);
                });
            }
          });

        });
      </script>