
<?php
use App\Libraries\PostType;
$base_model->add_css('admin/css/posts_list.css');
$base_model->add_css(  'themes/' . THEMENAME . '/css/post_list.css');
$base_model->add_css(  'themes/' . THEMENAME . '/css/users.css');

?>
    <style>
        .input-group-text {
            margin-bottom: 10px;
        }
        .select2 .select2-selection {
            height: 35px;
            padding: 3px
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages': ['corechart']});
        google.charts.setOnLoadCallback(drawVisualization);

        function drawVisualization() {
            // Some raw data (not necessarily accurate)
            var data = google.visualization.arrayToDataTable([

                ['Nhân viên', 'Chưa duyệt', 'Đã duyệt', 'Chưa đạt tiêu chuẩn', 'KPI 20.000', 'KPI 30.000', 'KPI 40.000', 'KPI 35.000', 'KPI 45.000', 'KPI 45.000+Youtube'],
                <?php foreach ($dataPosts as $k =>$v) { ?>
                ['<?= $v['user_nicename']?>', <?= $v['non_public']?>, <?= $v['public']?>, <?= $v['type0']?>, <?= $v['type1']?>, <?= $v['type2']?>, <?= $v['type3']?>, <?= $v['type4']?>, <?= $v['type5']?>, <?= $v['type6']?>],
                <?php } ?>
            ]);

            var options = {
                title: 'Biểu đồ thống kê bài viết theo thời gian',
                vAxis: {title: 'Số bài'},
                hAxis: {title: 'Nhân viên'},
                seriesType: 'bars',
                series: {
                    6: {type: 'line'}
                }
            };

            var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>


<div class="w90">
    <div class="widget-box ng-main-content" id="myApp">
        <div class="row">
            <div class="col small-12 medium-2 large-2 global-profile-menu">
                <?php
                $menu_model->the_menu( 'user-profile-menu' );
                ?>
            </div>
            <div class="col-10">
                <div class="widget-content nopadding">
                    <div style="height: auto; width: 100%;">
                        <form name="frm_admin_search_controller" action="" method="get">
                            <input type="hidden" id="for_search" name="for_search" value="1">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="width: 35%;">
                                        <div class="form-group">
                                            <select class="form-control" id="author_id"
                                                    name="author_id" style="width: 100%;">
                                                <option selected value="<?php echo $author['ID']; ?>">
                                                    <?php echo $author['user_nicename']; ?>
                                                </option>
                                            </select>
                                        </div>
                                    </td>
                                    <td style="width: 20%; padding-left: 10px;">

                                        <input title="Thời gian duyệt từ ngày" autocomplete="off" type="date" id="startDate" class="form-control mb-0"
                                               name="start_date"
                                               placeholder="Từ ngày" value="<?= @$start_date ?>">
                                    </td>
                                    <td style="width: 20%; padding-left: 10px;">
                                        <input title="Thời gian duyệt đến ngày" autocomplete="off" type="date" id="endDate" class="form-control mb-0"
                                               name="end_date"
                                               placeholder="Đến ngày" value="<?= @$end_date ?>">
                                    </td>
                                    <td style="width: auto; padding-left: 10px" colspan="3">
                                        <button class="btn btn-success" type="submit" style="width: 100px;">Lọc</button>
                                    </td>
                                </tr>

                            </table>
                        </form>
                    </div>
                    <br>
                    <div class="card shadow mb-4" style="font-size: 100%!important;">
                        <div class="card-body">
                            <?php if (!empty($dataPosts)) { ?>
                                <div id="chart_div" style="width: 100%; height: 600px;"></div>
                            <?php } else { ?>
                                <p class="text-primary">Không có dữ liệu</p>
                                <div id="chart_div" style="width: 100%; height: 600px;"></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (!empty($dataPosts)) { ?>
                        <div class="card shadow mb-4" style="color: #0a0a0a!important;">
                            <div class="card-body">

                                <div class="row">
                                    <h3 class="mb-3">Thông số KPI: <?= $session_data['user_nicename'] ?> </h3>
                                    <div class="col-6">
                                        <p>Tổng số bài đã viết: <?= @$totalPost ?> </p>
                                        <p>Tổng số bài được duyệt: <?= @$public ?> </p>
                                        <p>Tổng số bài chưa được duyệt: <?= @$nonPublic ?> </p>
                                        <p title="Cần phải chỉnh sửa ngay trong tháng" class="text-danger">Số bài chưa đạt tiêu chuẩn: <span class="bold fz-25" ><?= @$type0 ?></span>
                                            <a class="badge text-primary text-decoration-underline" target="_blank" title="Click để xem danh sách bài viết chưa đạt KPI" href="<?php base_url() ?>c/lists?start_date=<?=$start_date?>&end_date=<?=$end_date?>&salary_type=<?=SALARY_TYPE_0?>">Chi tiết</a></p>
                                    </div>
                                    <div class="col-6">
                                        <p>KPI 20.000: <?= @$type1 ?> * <?= number_format(SALARY_TYPE[SALARY_TYPE_1], 0, ',', '.') . ' đ' ?>
                                            = <?= number_format(@$salary1, 0, ',', '.') . ' đ' ?> <a class="badge text-primary text-decoration-underline" target="_blank" title="Click để xem" href="<?php base_url() ?>c/lists?start_date=<?=$start_date?>&end_date=<?=$end_date?>&salary_type=<?=SALARY_TYPE_1?>">Chi tiết</a> </p>
                                        <p>KPI 30.000: <?= @$type2 ?> * <?= number_format(SALARY_TYPE[SALARY_TYPE_2], 0, ',', '.') . ' đ' ?>
                                            = <?= number_format(@$salary2, 0, ',', '.') . ' đ' ?> <a class="badge text-primary text-decoration-underline" target="_blank" title="Click để xem" href="<?php base_url() ?>c/lists?start_date=<?=$start_date?>&end_date=<?=$end_date?>&salary_type=<?=SALARY_TYPE_2?>">Chi tiết</a></p>
                                        <p>KPI 40.000: <?= @$type3 ?> * <?= number_format(SALARY_TYPE[SALARY_TYPE_3], 0, ',', '.') . ' đ' ?>
                                            = <?= number_format(@$salary3, 0, ',', '.') . ' đ' ?> <a class="badge text-primary text-decoration-underline" target="_blank" title="Click để xem" href="<?php base_url() ?>c/lists?start_date=<?=$start_date?>&end_date=<?=$end_date?>&salary_type=<?=SALARY_TYPE_3?>">Chi tiết</a></p>
                                        <p class="text-success bold">Tổng
                                            tiền: <?= number_format(@$salary, 0, ',', '.') . ' đ' ?> </p>
                                        <p>KPI 35.000: <?= @$type4 ?> * <?= number_format(SALARY_TYPE[SALARY_TYPE_4], 0, ',', '.') . ' đ' ?>
                                            = <?= number_format(@$salary4, 0, ',', '.') . ' đ' ?></p>
                                        <p>KPI 45.000: <?= @$type5 ?> * <?= number_format(SALARY_TYPE[SALARY_TYPE_5], 0, ',', '.') . ' đ' ?>
                                            = <?= number_format(@$salary5, 0, ',', '.') . ' đ' ?></p>
                                        <p>KPI 45.000,Youtube: <?= @$type6 ?> * <?= number_format(SALARY_TYPE[SALARY_TYPE_6], 0, ',', '.') . ' đ' ?>
                                            = <?= number_format(@$salary6, 0, ',', '.') . ' đ' ?></p>

                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <h4 class="bold badge-success">Điều kiện áp dụng KPI</h4>
                                        <p><i>Số lượng từ Thù lao (VND) </i></p>
                                        <p><i> 1.600 -2.200 từ >= 2 hình ảnh 20.000/1 bài viết </i></p>
                                        <p><i> 2.200 -3000 từ >= 3 hình ảnh 30.000/1 bài viết </i></p>
                                        <p><i> Trên 3.000 từ >= 3 hình ảnh 40.000/1 bài viết </i></p>
                                        <p><i> 500-1000 từ + 5 hình ảnh/hoạt ảnh/sơ đồ cây 35.000/1 bài viết</i></p>
                                        <p><i> 500-1000 từ + 6 hình ảnh/hoạt ảnh/sơ đồ cây 45.000/1 bài viết</i></p>
                                        <p><i> 500-1000 từ + 4 hình ảnh/hoạt ảnh/sơ đồ cây + 1 Video 45.000/1 bài viết</i></p>
                                        <p class="text-danger"><i> Không đáp ứng một trong các điều kiện trên ko tính KPI </i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <br>
</div>











