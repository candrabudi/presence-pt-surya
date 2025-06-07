@extends('_admin.layouts.app')

@section('content')
    <div class="col-xl-12 col-lg-12 col-md-12 flex-column">
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold">Total Absensi Karyawan per Hari</h6>
                    </div>
                    <div class="card-body">
                        <div class="ac-line-transparent" id="apex-absensiHarian" style="min-height: 155px;"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold">Employees Availability</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-2 row-deck">
                            <div class="col-md-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body ">
                                        <i class="icofont-checked fs-3"></i>
                                        <h6 class="mt-3 mb-0 fw-bold small-14">Attendance</h6>
                                        <span class="text-muted">{{ $attendanceCount }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body ">
                                        <i class="icofont-stopwatch fs-3"></i>
                                        <h6 class="mt-3 mb-0 fw-bold small-14">Late Coming</h6>
                                        <span class="text-muted">{{ $lateCount }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body ">
                                        <i class="icofont-ban fs-3"></i>
                                        <h6 class="mt-3 mb-0 fw-bold small-14">Absent</h6>
                                        <span class="text-muted">{{ $absentCount }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="card">
                                    <div class="card-body ">
                                        <i class="icofont-beach-bed fs-3"></i>
                                        <h6 class="mt-3 mb-0 fw-bold small-14">Leave Apply</h6>
                                        <span class="text-muted">{{ $leaveApplyCount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold">Total Karyawan</h6>
                        <h4 class="mb-0 fw-bold">{{ array_sum($genderChart) }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="mt-3" id="apex-MainCategories" style="height: 235px;"></div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                        <h6 class="mb-0 fw-bold ">Absensi vs Cuti Tahun {{ $year }}</h6>
                    </div>
                    <div class="card-body">
                        <div id="hiringsources" style="min-height: 315px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            var options = {
                series: [{
                    name: 'Jumlah Karyawan Absen',
                    data: @json($totals)
                }],
                chart: {
                    height: 140,
                    type: 'line',
                    toolbar: {
                        show: false,
                    }
                },
                grid: {
                    show: false,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false
                        }
                    }
                },
                stroke: {
                    width: 4,
                    curve: 'smooth',
                    colors: ['var(--chart-color2)'], 
                },
                xaxis: {
                    type: 'datetime',
                    categories: @json($days),
                    tickAmount: 10,
                    labels: {
                        formatter: function(value, timestamp, opts) {
                            return opts.dateFormatter(new Date(timestamp), 'dd MMM')
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        gradientToColors: ["var(--chart-color3)"],
                        shadeIntensity: 1,
                        type: 'horizontal',
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 100, 100, 100],
                    },
                },
                markers: {
                    size: 3,
                    colors: ["#FFA41B"],
                    strokeColors: "#ffffff",
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                yaxis: {
                    show: false,
                    min: -10,
                    max: 50,
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " orang hadir";
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#apex-absensiHarian"), options);
            chart.render();
        });
    </script>


    <script>
        $(function() {
            "use strict";

            $(document).ready(function() {
                var options = {
                    chart: {
                        height: 250,
                        type: 'donut',
                        align: 'center',
                    },
                    labels: ['Laki-laki', 'Perempuan', 'Lainnya'],
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        show: true,
                    },
                    colors: ['var(--chart-color4)', 'var(--chart-color3)', '#999999'],
                    series: [
                        {{ $genderChart['male'] ?? 0 }},
                        {{ $genderChart['female'] ?? 0 }},
                        {{ $genderChart['other'] ?? 0 }}
                    ],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#apex-MainCategories"), options);
                chart.render();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var options = {
                series: [{
                    name: 'Absensi',
                    data: @json($attendanceData)
                }, {
                    name: 'Cuti',
                    data: @json($leaveData)
                }],
                chart: {
                    type: 'bar',
                    height: 300,
                    stacked: true,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: true
                    }
                },
                colors: ['var(--chart-color1)', 'var(--chart-color3)'],
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov',
                        'Dec'
                    ]
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                },
                dataLabels: {
                    enabled: false,
                },
                fill: {
                    opacity: 1
                }
            };

            var chart = new ApexCharts(document.querySelector("#hiringsources"), options);
            chart.render();
        });
    </script>
@endpush
