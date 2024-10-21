@extends('GymOwner.master')
@section('title', 'Dashboard')
@section('content')

<!--**********************************
                                            Content body start
                                ***********************************-->
<style>
    .bg-yellow {
        background-color: #ffc107;
    }
</style>
<div class="content-body ">
    <!-- row -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl col-md-6">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-inline-block mb-4 ms--12 position-relative donut-chart-sale">
                            <span class="donut1"
                                data-peity='{ "fill": ["rgb(192, 255, 134)", "rgba(255, 255, 255, 1)"],   "innerRadius": 45, "radius": 10}'>{{ $totalUsers }}/100</span>
                            <small class="text-primary">
                                <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path
                                        d="M24,14.6c0,0.6-1.2,1-2.6,1.2c-0.9-1.7-2.7-3-4.8-3.9c0.2-0.3,0.4-0.5,0.6-0.8c0.3,0,0.6,0,0.8,0  C21.1,11,24,12.9,24,14.6z M6.8,11c-0.3,0-0.6,0-0.8,0c-3.1,0-6,1.9-6,3.6c0,0.6,1.2,1,2.6,1.2c0.9-1.7,2.7-3,4.8-3.9  C7.2,11.6,7,11.3,6.8,11z M12,12c2.2,0,4-1.8,4-4s-1.8-4-4-4S8,5.8,8,8S9.8,12,12,12z M12,13c-4.1,0-8,2.6-8,5c0,2,8,2,8,2s8,0,8-2  C20,15.6,16.1,13,12,13z M17.7,10c0.1,0,0.2,0,0.3,0c1.7,0,3-1.3,3-3s-1.3-3-3-3c-0.5,0-0.9,0.1-1.3,0.3C17.5,5.3,18,6.6,18,8  C18,8.7,17.9,9.4,17.7,10z M6,10c0.1,0,0.2,0,0.3,0C6.1,9.4,6,8.7,6,8c0-1.4,0.5-2.7,1.3-3.7C6.9,4.1,6.5,4,6,4C4.3,4,3,5.3,3,7  S4.3,10,6,10z"
                                        fill="white" />
                                </svg>
                            </small>
                            <span class="circle bg-primary"></span>
                        </div>
                        <h2 class="fs-24 text-black font-w600 mb-0">{{ $totalUsers }}</h2>
                        <span class="fs-14">Total Users</span>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-6 col-sm-6">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-inline-block mb-4 ms--12 position-relative donut-chart-sale">
                            <span class="donut1"
                                data-peity='{ "fill": ["rgb(255, 195, 210)", "rgba(255, 255, 255, 1)"],   "innerRadius": 45, "radius": 10}'>{{ $totalStaffs }}/50</span>
                            <small class="text-primary">
                                <svg width="50" height="50" fill="none" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"
                                    viewBox="0 0 256 256" enable-background="new 0 0 256 256" xml:space="preserve">
                                    <g>
                                        <g>
                                            <g>
                                                <path fill="white"
                                                    d="M59.8,45.5c-3.7,0.7-8.3,3.1-10.8,5.7c-4.2,4.2-6.2,9.8-6.2,18.2c0,3.8-0.1,4.7-0.9,5.5c-3,3-1,12.6,3.5,18c0.9,1.1,2,3.1,2.6,4.4c3.3,9.1,12.1,15.4,19.9,14.3c6.1-0.8,12.2-5.6,15.2-11.9c2-4.1,2.3-4.6,4.9-8.6c1.1-1.7,2.5-4.3,2.9-5.8c1-3.3,0.8-9-0.3-10.3c-0.6-0.6-0.9-2.4-1.1-6.1c-0.3-5.5-1.4-9.5-3.2-11.5c-0.5-0.6-1.2-2-1.5-3.2c-1.1-4.1-5.2-7.1-11.9-8.7C69.3,44.9,63.6,44.8,59.8,45.5z" />
                                                <path fill="white"
                                                    d="M182.9,45.7c-6.6,1.6-11.4,5.5-14.2,11.4c-1.4,3.1-1.6,3.7-1.7,9.9c-0.2,6.1-0.3,6.7-1.4,8c-1,1.2-1.2,2-1.2,4.7c0,4.4,1,7.6,3.5,11.4c2.7,3.9,3,4.4,4.9,8.6c0.9,2.1,2.7,4.5,4.2,6.1c7.2,7.4,17.3,7.7,24.7,0.8c2.7-2.5,5.7-7.2,6.7-10.5c0.2-0.7,1.1-2.1,2.1-3.2c3.4-4,5.4-10,4.8-14.7c-0.1-1.3-0.7-2.8-1.2-3.2c-0.7-0.7-0.9-2-1.1-6.2c-0.2-6.1-0.8-8.4-2.6-10.5c-0.6-0.8-1.5-2.6-1.9-3.8c-1.3-4.3-4.7-6.8-11.4-8.6C192.7,44.8,187.1,44.7,182.9,45.7z" />
                                                <path fill="white"
                                                    d="M120.7,73.5C111.3,75,104,80.2,100.4,88c-1.9,4.2-2.5,7.3-2.5,14.5c0,5.3-0.1,6.4-0.8,7c-3,2.5-2.8,11.5,0.4,17.8c0.5,1,2,3.2,3.3,5c1.3,1.8,2.8,4.3,3.2,5.8c1.1,3.4,5.2,9.4,8,11.8c5,4.3,11.6,6.3,17.1,5.5c8.4-1.4,16.8-9,19.7-17.9c0.4-1.4,1.7-3.5,2.8-4.7c5.9-6.7,8.2-18.8,4.4-22.6c-0.7-0.7-0.9-2-1.1-7.5c-0.3-7.1-1.1-10.2-3.6-13.5c-0.7-0.9-1.6-2.8-2-4.2c-0.9-3.2-3.9-6.4-7.3-8C136,73.8,127.2,72.6,120.7,73.5z" />
                                                <path fill="white"
                                                    d="M40.7,109.3c-12.4,5.1-16.4,7.3-20.2,11.2c-3.9,3.9-5.9,7.4-8.1,13.9c-1.5,4.6-2.8,11.9-2.3,13.7c0.3,1.4,4.4,3.1,11.6,4.8c10.4,2.5,20.9,3.6,37.2,4.1l11.4,0.3l2.9-1.7c4.7-2.9,11.3-6,19-9c6.5-2.6,7.2-3,6.9-3.9c-0.3-1-2.1-4.2-6.1-10.6c-4.1-6.5-5.8-16.1-3.8-21.5l0.7-2.1l-2.2-0.8c-1.2-0.5-2.4-0.6-2.6-0.4c-0.2,0.2-0.9,2.6-1.4,5.1c-3,13.1-6.4,22.3-9.8,26.2c-3.1,3.5-8,4.8-11.7,3.1c-2.2-1-5.3-4.4-6.8-7.5c-2.3-4.5-3.3-7.6-5.9-17.6l-2.5-9.9L40.7,109.3z" />
                                                <path fill="white"
                                                    d="M207.7,111.3c-3.7,15.8-6.6,23.2-10.3,27.3c-2.5,2.7-4.7,3.8-7.5,3.8c-7.6,0-12.5-8-17.2-27.8c-0.9-3.8-1.8-7.1-2-7.3c-0.2-0.2-2,0.2-3.9,1c-3.3,1.3-3.5,1.4-3.2,2.6c1.8,7.6,0,16-4.9,22.9c-2.1,2.9-5.2,8.7-5.2,9.5c0,0.2,2.2,1.3,4.8,2.3c6.8,2.7,18.1,7.8,21.5,9.9l2.9,1.8l12.8-0.3c17.1-0.4,28.1-1.6,38.7-4.1c7.2-1.7,11.3-3.4,11.6-4.8c0.4-1.8-0.8-9.1-2.3-13.7c-2.2-6.5-4.2-9.9-8.1-13.9c-3-3-4.3-3.9-9.1-6.3c-3.1-1.5-8.3-3.8-11.6-5.2l-6-2.5L207.7,111.3z" />
                                                <path fill="white"
                                                    d="M94,152.8c-13.8,5.8-18.7,8.4-22.8,12.3c-5.8,5.4-9.7,12.6-12.2,22c-1.1,4.4-2.1,12.1-1.7,13.4c0.6,2,12,5.6,23.9,7.5c14.6,2.4,23,3,45.2,3c20.7,0,29-0.4,42-2.4c10.1-1.5,22.7-4.9,25.7-6.9c1.2-0.8,1.3-0.9,1-5.3c-0.5-8.5-3.9-18.5-8.5-25.4c-3.3-5-7.3-8.4-14-11.8c-5-2.5-18.9-8.6-22-9.6c-0.9-0.3-1.1,0.1-2.1,3.7c-2.5,9.3-5.8,19.7-7.9,25.5c-2.9,7.6-5.8,14-6.2,13.6c-0.2-0.1-0.8-3.3-1.4-7.1c-1.1-6.4-1.1-6.8-0.3-7.8c0.9-1.1,3.2-12.1,2.9-14.1l-0.1-1.2l-8.9-0.1c-7.1-0.1-9,0-9.5,0.5c-0.8,1,1.7,14.1,2.8,15c0.7,0.5,0.7,1.3-0.3,7.7c-0.6,3.9-1.3,7.1-1.4,7.1c-0.4,0-5-10.2-7-15.6c-2.1-5.6-7-22.4-7.7-25.8c-0.2-1-0.6-1.8-0.9-1.8C102.4,149.3,98.5,150.8,94,152.8z" />
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </small>
                            <span class="circle bg-danger"></span>
                        </div>
                        <h2 class="fs-24 text-black font-w600 mb-0">{{ $totalStaffs }}</h2>
                        <span class="fs-14">Total Staffs</span>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-inline-block mb-4 ms--12 position-relative donut-chart-sale">
                            <span class="donut1"
                                data-peity='{ "fill": ["rgb(255, 213, 174)", "rgba(255, 255, 255, 1)"],   "innerRadius": 45, "radius": 10}'>{{ $totalSubscriptions }}/20</span>
                            <small class="text-primary">
                                <svg width="40" height="40" version="1.1" id="Layer_1"
                                    xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    viewBox="0 0 122.88 109.93" xml:space="preserve">
                                    <g>
                                        <path
                                            d="M115.47,65.19c-2.39,12.7-9.16,23.86-18.67,31.85c-9.57,8.04-21.89,12.88-35.33,12.88c-12.63,0-24.28-4.27-33.57-11.45 C18.4,91.14,11.38,80.77,8.27,68.81l6.86-1.78c2.7,10.41,8.82,19.44,17.09,25.83c8.08,6.24,18.22,9.95,29.24,9.95 c11.73,0,22.47-4.21,30.78-11.19c7.95-6.68,13.7-15.91,15.98-26.44h-7.33l10.99-13.39l10.99,13.39H115.47L115.47,65.19z M61.29,69.07V56.52c-4.42-1.12-7.65-2.81-9.7-5.07c-2.06-2.27-3.1-5.02-3.1-8.26c0-3.28,1.17-6.04,3.5-8.26 c2.33-2.23,5.43-3.51,9.3-3.85v-2.95h4.94v2.95c3.62,0.38,6.49,1.47,8.64,3.26c2.13,1.79,3.5,4.19,4.09,7.19l-8.63,0.98 c-0.53-2.36-1.9-3.96-4.1-4.8v11.71c5.46,1.29,9.18,2.98,11.15,5.04c1.98,2.07,2.97,4.72,2.97,7.96c0,3.62-1.24,6.66-3.73,9.14 c-2.49,2.48-5.95,4.02-10.39,4.63v5.6h-4.94v-5.53c-3.9-0.42-7.06-1.69-9.51-3.83c-2.45-2.14-4-5.17-4.68-9.08l8.83-0.92 c0.36,1.6,1.04,2.97,2.04,4.13C58.97,67.72,60.07,68.55,61.29,69.07L61.29,69.07z M61.29,37.6c-1.33,0.42-2.38,1.11-3.15,2.07 c-0.78,0.96-1.16,2.02-1.16,3.18c0,1.06,0.35,2.04,1.06,2.95c0.71,0.9,1.8,1.64,3.26,2.19V37.6L61.29,37.6z M66.23,69.57 c1.7-0.33,3.1-1.05,4.16-2.15C71.47,66.31,72,65.01,72,63.5c0-1.33-0.45-2.49-1.36-3.45c-0.89-0.97-2.36-1.71-4.42-2.23V69.57 L66.23,69.57z M7.46,44.74C9.83,32.15,16.5,21.08,25.87,13.1C35.47,4.93,47.9,0,61.46,0c11.93,0,22.97,3.8,31.98,10.26 c9.25,6.63,16.35,16.06,20.08,27.06l-3.36,1.14l-3.36,1.14c-0.09-0.28-0.19-0.56-0.29-0.83c-3.31-9.21-9.38-17.11-17.2-22.72 c-7.84-5.62-17.45-8.93-27.84-8.93c-11.84,0-22.67,4.28-31.01,11.38c-7.84,6.67-13.49,15.82-15.76,26.24h7.29L10.99,58.13L0,44.74 H7.46L7.46,44.74z"
                                            fill="white" stroke="white" stroke-width="3" />
                                    </g>
                                </svg>
                            </small>
                            <span class="circle bg-warning"></span>
                        </div>
                        <h2 class="fs-24 text-black font-w600 mb-0">{{ $totalSubscriptions }}</h2>
                        <span class="fs-14">Total Subscriptions</span>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-inline-block mb-4 ms--12 position-relative donut-chart-sale">
                            <span class="donut1"
                                data-peity='{ "fill": ["rgba(23, 162, 184, 0.3)", "rgba(255, 255, 255, 1)"],   "innerRadius": 45, "radius": 10}'>{{ $totalWorkouts }}/50</span>
                            <small class="text-primary">

                                <svg width="60" height="60" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 256 256"
                                    xml:space="preserve">

                                    <defs>
                                    </defs>
                                    <g style="stroke: white; stroke-width: 3; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                        transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                        <path
                                            d="M 64.873 50.337 H 25.127 c -0.552 0 -1 -0.447 -1 -1 v -8.674 c 0 -0.552 0.448 -1 1 -1 h 39.746 c 0.553 0 1 0.448 1 1 v 8.674 C 65.873 49.89 65.426 50.337 64.873 50.337 z M 26.127 48.337 h 37.746 v -6.674 H 26.127 V 48.337 z"
                                            style="fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" />
                                        <path
                                            d="M 25.127 65.873 h -8.673 c -0.552 0 -1 -0.447 -1 -1 V 25.127 c 0 -0.552 0.448 -1 1 -1 h 8.673 c 0.552 0 1 0.448 1 1 v 39.746 C 26.127 65.426 25.679 65.873 25.127 65.873 z M 17.454 63.873 h 6.673 V 26.127 h -6.673 V 63.873 z"
                                            style="fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" />
                                        <path
                                            d="M 16.454 59.104 H 7.78 c -0.552 0 -1 -0.447 -1 -1 V 31.896 c 0 -0.552 0.448 -1 1 -1 h 8.673 c 0.552 0 1 0.448 1 1 v 26.208 C 17.454 58.656 17.006 59.104 16.454 59.104 z M 8.78 57.104 h 6.673 V 32.896 H 8.78 V 57.104 z"
                                            style="fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" />
                                        <path
                                            d="M 73.547 65.873 h -8.674 c -0.553 0 -1 -0.447 -1 -1 V 25.127 c 0 -0.552 0.447 -1 1 -1 h 8.674 c 0.553 0 1 0.448 1 1 v 39.746 C 74.547 65.426 74.1 65.873 73.547 65.873 z M 65.873 63.873 h 6.674 V 26.127 h -6.674 V 63.873 z"
                                            style="fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" />
                                        <path
                                            d="M 82.22 59.104 h -8.673 c -0.553 0 -1 -0.447 -1 -1 V 31.896 c 0 -0.552 0.447 -1 1 -1 h 8.673 c 0.553 0 1 0.448 1 1 v 26.208 C 83.22 58.656 82.772 59.104 82.22 59.104 z M 74.547 57.104 h 6.673 V 32.896 h -6.673 V 57.104 z"
                                            style="fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" />
                                        <path
                                            d="M 7.78 50.337 H 1 c -0.552 0 -1 -0.447 -1 -1 v -8.674 c 0 -0.552 0.448 -1 1 -1 h 6.78 c 0.552 0 1 0.448 1 1 v 8.674 C 8.78 49.89 8.333 50.337 7.78 50.337 z M 2 48.337 h 4.78 v -6.674 H 2 V 48.337 z"
                                            style="fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" />
                                        <path
                                            d="M 89 50.337 h -6.78 c -0.553 0 -1 -0.447 -1 -1 v -8.674 c 0 -0.552 0.447 -1 1 -1 H 89 c 0.553 0 1 0.448 1 1 v 8.674 C 90 49.89 89.553 50.337 89 50.337 z M 83.22 48.337 H 88 v -6.674 h -4.78 V 48.337 z"
                                            style="fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" />
                                    </g>
                                </svg>

                            </small>
                            <span class="circle bg-info"></span>
                        </div>
                        <h2 class="fs-24 text-black font-w600 mb-0">{{ $totalWorkouts }}</h2>
                        <span class="fs-14">Total Workouts</span>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-inline-block mb-4 ms--12 position-relative donut-chart-sale">
                            <span class="donut1"
                                data-peity='{ "fill": ["rgba(40, 167, 69, 0.3)", "rgba(255, 255, 255, 1)"],   "innerRadius": 45, "radius": 10}'>{{ $totalDiets }}/20</span>
                            <small class="text-primary">

                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    fill="#000000" height="40" width="40" version="1.1" id="Capa_1"
                                    viewBox="0 0 490 490" xml:space="preserve">
                                    <g>
                                        <path
                                            d="M348.399,104.848c-1.257,0-2.489,0.022-3.707,0.066c-45.669,1.659-74.383,25.793-91.667,32.88   c-4.223-22.172-5.759-69.433,40.609-116.225L271.891,0.006c-25.597,25.826-39.003,51.986-45.658,75.607   C173.742,6.109,104.742,15.819,104.742,15.819c48.35,91.049,106.284,70.783,120.351,64.088   c-4.731,18.899-5.271,36.013-4.053,49.641c-17.489-9.865-41.998-23.41-75.732-24.635c-1.215-0.044-2.454-0.066-3.708-0.066   C87.663,104.846,0,146.111,0,267.252c0,123.954,99.709,222.741,150.78,222.741c51.07,0,68.821-14.472,94.22-14.472   c25.399,0,43.149,14.472,94.22,14.472c51.07,0,150.78-98.787,150.78-222.741C490,146.119,402.337,104.848,348.399,104.848z    M339.22,459.369c-25.901,0-41.088-4.088-55.775-8.041c-11.746-3.162-23.891-6.431-38.445-6.431c-14.554,0-26.7,3.269-38.446,6.431   c-14.687,3.953-29.875,8.041-55.774,8.041c-29.042,0-120.155-79.717-120.155-192.116c0-45.085,13.554-79.987,40.288-103.736   c23.276-20.677,51.776-28.045,70.688-28.044c0.878,0,1.746,0.016,2.595,0.047c26.826,0.974,46.696,12.186,62.66,21.195   c13.104,7.395,24.421,13.781,38.144,13.781c13.723,0,25.04-6.386,38.143-13.781c15.965-9.009,35.834-20.221,62.659-21.195   c0.853-0.031,1.716-0.047,2.596-0.047c18.911,0,47.41,7.368,70.688,28.047c26.733,23.75,40.289,58.65,40.289,103.732   C459.375,379.652,368.262,459.369,339.22,459.369z"
                                            fill="white" stroke="white" stroke-width="10" />
                                    </g>
                                </svg>

                            </small>
                            <span class="circle bg-success"></span>
                        </div>
                        <h2 class="fs-24 text-black font-w600 mb-0">{{ $totalDiets }}</h2>
                        <span class="fs-14">Total Diets</span>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-inline-block mb-4 ms--12 position-relative donut-chart-sale">
                            <span class="donut1"
                                data-peity='{ "fill": ["rgba(108, 117, 125, 0.3)", "rgba(255, 255, 255, 1)"],   "innerRadius": 45, "radius": 10}'>{{ $totalActiveUsers }}/25</span>
                            <small class="text-primary">
                                <svg width="40" height="40" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <g id="Layer_2" data-name="Layer 2">
                                        <g id="Layer_1-2" data-name="Layer 1">
                                            <path
                                                d="M12,12A6,6,0,1,0,6,6,6,6,0,0,0,12,12ZM12,2A4,4,0,1,1,8,6,4,4,0,0,1,12,2Zm6,10a6,6,0,1,0,6,6A6,6,0,0,0,18,12Zm0,10a4,4,0,1,1,3.09-6.51L18,18.59l-1.29-1.3a1,1,0,0,0-1.42,1.42l2,2a1,1,0,0,0,1.42,0L22,17.47A4.53,4.53,0,0,1,22,18,4,4,0,0,1,18,22Zm-6,1a1,1,0,0,1-1,1H3a3,3,0,0,1-3-3,7,7,0,0,1,7-7h3a1,1,0,0,1,0,2H7a5,5,0,0,0-5,5,1,1,0,0,0,1,1h8A1,1,0,0,1,12,23Z"
                                                fill="white" />
                                        </g>
                                    </g>
                                </svg>
                            </small>
                            <span class="circle bg-secondary"></span>
                        </div>
                        <h2 class="fs-24 text-black font-w600 mb-0">{{ $totalActiveUsers }}</h2>
                        <span class="fs-14">Total Active Users</span>
                    </div>
                </div>
            </div>
            <div class="col-xl col-md-4 col-sm-6">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="d-inline-block mb-4 ms--12 position-relative donut-chart-sale">
                            <span class="donut1"
                                data-peity='{ "fill": ["rgba(255, 255, 0, 0.3)", "rgba(255, 255, 255, 1)"],   "innerRadius": 45, "radius": 10}'>{{ $totalCoupons }}/50</span>
                            <small class="text-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1" width="40" height="40" viewBox="0 0 256 256" xml:space="preserve">
                                    <defs></defs>
                                    <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;"
                                        transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)">
                                        <path
                                            d="M 87.172 17.696 H 67.083 c 0.035 -0.2 0.062 -0.403 0.062 -0.613 V 7.205 c 0 -1.306 -0.678 -2.471 -1.815 -3.115 c -1.137 -0.645 -2.485 -0.629 -3.605 0.043 l -16.49 9.877 c -0.084 0.05 -0.156 0.112 -0.235 0.168 c -0.078 -0.056 -0.15 -0.117 -0.234 -0.167 L 28.275 4.133 c -1.121 -0.67 -2.468 -0.687 -3.604 -0.043 c -1.137 0.644 -1.815 1.809 -1.815 3.115 v 9.877 c 0 0.21 0.027 0.413 0.062 0.613 H 2.828 C 1.269 17.696 0 18.964 0 20.523 v 10.02 c 0 1.559 1.269 2.828 2.828 2.828 h 2.513 v 48.956 c 0 2.236 1.819 4.056 4.055 4.056 h 28.722 h 13.764 h 28.723 c 2.236 0 4.055 -1.82 4.055 -4.056 V 33.371 h 2.513 c 1.56 0 2.828 -1.269 2.828 -2.828 v -10.02 C 90 18.964 88.732 17.696 87.172 17.696 z M 46.759 16.556 l 16.49 -9.877 c 0.112 -0.067 0.218 -0.091 0.313 -0.091 c 0.13 0 0.238 0.045 0.305 0.083 c 0.116 0.066 0.311 0.223 0.311 0.534 v 9.877 c 0 0.338 -0.275 0.613 -0.613 0.613 h -5.35 h -11.14 c -0.385 0 -0.527 -0.25 -0.58 -0.42 c 0.008 -0.142 0.017 -0.285 0.009 -0.425 C 46.544 16.747 46.615 16.642 46.759 16.556 z M 55.247 30.404 h -3.366 H 38.118 h -3.366 v -9.741 h 8.174 h 4.149 h 8.173 V 30.404 z M 25.822 17.082 V 7.205 c 0 -0.311 0.195 -0.468 0.311 -0.534 c 0.068 -0.038 0.175 -0.083 0.305 -0.083 c 0.094 0 0.2 0.024 0.312 0.09 l 16.491 9.878 c 0.144 0.087 0.214 0.191 0.255 0.296 c -0.008 0.139 0.001 0.281 0.009 0.422 c -0.053 0.17 -0.194 0.422 -0.58 0.422 H 31.785 h -5.349 C 26.098 17.696 25.822 17.42 25.822 17.082 z M 2.967 30.404 v -9.741 h 23.469 h 5.349 v 9.741 H 5.341 H 2.967 z M 9.396 83.415 c -0.6 0 -1.088 -0.489 -1.088 -1.088 V 33.371 h 23.477 h 6.333 v 50.044 H 9.396 z M 41.085 83.415 V 33.371 h 7.83 v 50.044 H 41.085 z M 81.692 82.327 c 0 0.6 -0.488 1.088 -1.088 1.088 H 51.882 V 33.371 h 6.333 h 23.477 V 82.327 z M 87.033 30.404 h -2.374 H 58.215 v -9.741 h 5.35 h 23.469 V 30.404 z"
                                            style="fill: white; stroke: white; stroke-width: 4; stroke-linecap: round;" />
                                    </g>
                                </svg>

                            </small>
                            <span class="circle bg-yellow"></span>
                        </div>
                        <h2 class="fs-24 text-black font-w600 mb-0">{{ $totalCoupons }}</h2>
                        <span class="fs-14">Total Coupons</span>
                    </div>
                </div>
            </div>
            <!-- Blade Template -->
            <div class="col-xl-9 col-xxl-8">
                <div class="card">
                    <div class="card-header flex-wrap pb-0 border-0">
                        <div class="me-auto pe-3 mb-2">
                            <h4 class="text-black fs-20">User Attendance Chart</h4>
                            <p class="fs-13 mb-2 mb-sm-0 text-black">Day-wise User Attendance</p>
                        </div>
                        <div class="d-flex me-3 me-sm-4 mb-2">
                            <!-- Present Percentage -->
                            <svg class="me-2 mt-1" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip4)">
                                    <path
                                        d="M0.988941 17.074C0.32826 17.2006 -0.1046 17.8385 0.021967 18.4992C0.133346 19.0814 0.644678 19.4864 1.21676 19.4864C1.2927 19.4864 1.37117 19.4788 1.44712 19.4636L6.45918 18.5017C6.74522 18.446 7.00089 18.2916 7.18315 18.0638L9.33479 15.3502L8.61591 14.9832C8.08433 14.7148 7.71473 14.2288 7.58816 13.639L5.55802 16.1982L0.988941 17.074Z"
                                        fill="#FF9432" />
                                    <path
                                        d="M18.84 6.493C20.3135 6.493 21.508 5.29848 21.508 3.82496C21.508 2.35144 20.3135 1.15692 18.84 1.15692C17.3664 1.15692 16.1719 2.35144 16.1719 3.82496C16.1719 5.29848 17.3664 6.493 18.84 6.493Z"
                                        fill="#FF9432" />
                                    <path
                                        d="M13.0179 3.15671C12.7369 2.86813 12.4762 2.75422 12.1902 2.75422C12.0864 2.75422 11.9826 2.76941 11.8712 2.79472L7.29202 3.88067C6.65918 4.03002 6.26936 4.66539 6.4187 5.29569C6.5478 5.8374 7.02876 6.20192 7.56287 6.20192C7.65403 6.20192 7.74513 6.19179 7.83628 6.16901L11.7371 5.24507C11.9902 5.52605 13.2584 6.90057 13.4888 7.14358C11.8763 8.86996 10.2638 10.5938 8.65135 12.3202C8.62604 12.3481 8.60328 12.3759 8.58047 12.4037C8.10964 13.0036 8.25395 13.9453 8.96273 14.3022L13.9064 16.826L11.3396 20.985C10.9878 21.5571 11.165 22.3063 11.7371 22.6607C11.937 22.7848 12.1573 22.843 12.375 22.843C12.7825 22.843 13.1824 22.638 13.4128 22.2658L16.6732 16.9829C16.8529 16.6918 16.901 16.34 16.8073 16.0134C16.7137 15.6843 16.4884 15.411 16.1821 15.2565L12.8331 13.5529L16.3543 9.7863L19.0122 12.0392C19.2324 12.2265 19.5032 12.3176 19.7716 12.3176C20.0601 12.3176 20.3487 12.2113 20.574 12.0038L23.6243 9.16106C24.1002 8.71808 24.128 7.97386 23.685 7.49797C23.4521 7.24989 23.1382 7.12333 22.8243 7.12333C22.5383 7.12333 22.2497 7.22711 22.0244 7.43721L19.7412 9.56101C19.7386 9.56354 14.0178 4.1819 13.0179 3.15671Z"
                                        fill="#FF9432" />
                                </g>
                                <defs>
                                    <clipPath id="clip4">
                                        <rect width="24" height="24" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <div>
                                <h4 class="fs-18 text-black font-w600 mb-0" id="presentPercentage">0%</h4>
                                <span class="fs-12 text-black">Present</span>
                            </div>
                        </div>
                        <div class="d-flex me-3 me-sm-4 mb-2">
                            <!-- Absent Percentage -->
                            <svg class="me-2 mt-1" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M10.8586 5.22599L5.87121 10.5543C5.50758 11.0846 5.64394 11.8068 6.17172 12.1679L11.1945 15.6098V18.9558C11.1945 19.5921 11.6995 20.125 12.3359 20.1376C12.9874 20.1477 13.5177 19.625 13.5177 18.976V15.0013C13.5177 14.6174 13.3283 14.2588 13.0126 14.0442L9.79041 11.8346L12.5025 8.95836L13.8914 12.1225C14.0758 12.5442 14.4949 12.817 14.9546 12.817H19.1844C19.8207 12.817 20.3536 12.3119 20.3662 11.6755C20.3763 11.024 19.8536 10.4937 19.2046 10.4937H15.7172C15.2576 9.44824 14.7677 8.41288 14.3409 7.35228C14.1237 6.81693 14.0025 6.5846 13.6036 6.21592C13.5227 6.14016 12.9596 5.62501 12.4571 5.16541C11.995 4.74619 11.2828 4.77397 10.8586 5.22599Z"
                                    fill="#1EA7C5" />
                                <path
                                    d="M15.6162 5.80681C17.0861 5.80681 18.2778 4.61517 18.2778 3.1452C18.2778 1.67523 17.0861 0.483582 15.6162 0.483582C14.1462 0.483582 12.9545 1.67523 12.9545 3.1452C12.9545 4.61517 14.1462 5.80681 15.6162 5.80681Z"
                                    fill="#1EA7C5" />
                                <path
                                    d="M4.89899 23.5164C7.60463 23.5164 9.79798 21.3231 9.79798 18.6174C9.79798 15.9118 7.60463 13.7184 4.89899 13.7184C2.19335 13.7184 0 15.9118 0 18.6174C0 21.3231 2.19335 23.5164 4.89899 23.5164Z"
                                    fill="#1EA7C5" />
                                <path
                                    d="M19.101 23.5164C21.8066 23.5164 24 21.3231 24 18.6174C24 15.9118 21.8066 13.7184 19.101 13.7184C16.3954 13.7184 14.202 15.9118 14.202 18.6174C14.202 21.3231 16.3954 23.5164 19.101 23.5164Z"
                                    fill="#1EA7C5" />
                            </svg>
                            <div>
                                <h4 class="fs-18 text-black font-w600 mb-0" id="absentPercentage">0%</h4>
                                <span class="fs-12 text-black">Absent</span>
                            </div>
                        </div>

                        <div class="dropdown mt-sm-0 mt-3 mb-0">
                            <button type="button" class="btn rounded border border-light dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false" id="monthDropdown">
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="javascript:void(0);">Monthly</a>
                                <a class="dropdown-item" href="javascript:void(0);">Weekly</a>
                                <a class="dropdown-item" href="javascript:void(0);">Daily</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <canvas id="attendanceChart"></canvas> <!-- Canvas for the chart -->
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-xxl-4 col-md-6">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="text-black fs-20 mb-0">Today's Users Present</h4>
                    </div>
                    <div class="card-body text-center">
                        <!-- Radial Bar Container -->
                        <div id="userRadialBar"></div>
                        <p class="fs-14">Stay committed to your fitness journey! Every day counts </p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-4 col-md-6">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="text-black fs-20 mb-0">Subscription Soon Expire</h4>
                        <a href="/gym-customers-subscriptions"
                            class="btn btn-primary btn-sm rounded d-none d-md-block">View All</a>
                    </div>

                    <div class="card-body">
                        <div class="scroll-container" style="max-height: 300px; overflow-y: auto;">
                            @foreach ($usersHistory as $index => $user)
                                                        <div class="media align-items-center border border-warning rounded p-3 mb-md-4 mb-3">
                                                            <div>
                                                                <h4 class="fs-18 text-black mb-0">{{ $user->users->firstname }}</h4>

                                                                {{-- Calculate remaining days --}}
                                                                @php
                                                                    $subscriptionEnd = \Carbon\Carbon::parse($user->subscription_end_date);
                                                                    $remainingDays = intval(
                                                                        \Carbon\Carbon::now()->diffInDays($subscriptionEnd, false),
                                                                    ); // Cast to integer
                                                                @endphp

                                                                {{-- Display remaining days --}}
                                                                @if ($remainingDays > 0)
                                                                    <span class="fs-14 text-warning">Remaining: {{ $remainingDays }}
                                                                        days</span>
                                                                @else
                                                                    <span class="fs-14 text-danger">Expired</span>
                                                                @endif
                                                            </div>

                                                        </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-xxl-4 col-md-6">
                <div class="card">
                    <div class="card-header border-0 pb-0">
                        <h4 class="text-black fs-20 mb-0">User Recent Payments</h4>
                        <a href="/customers-payment" class="btn btn-primary btn-sm rounded d-none d-md-block">View
                            All</a>
                    </div>

                    <div class="card-body">
                        <div class="scroll-container" style="max-height: 300px; overflow-y: auto;">
                            @foreach ($userRecentPayments as $index => $userPayments)
                                <div class="media align-items-center border border-warning rounded p-3 mb-md-4 mb-3">
                                    <div>
                                        <h4 class="fs-18 text-black mb-0">{{ $userPayments->name }}</h4>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-xl-9 col-xxl-8">
                <div class="card">
                    <div class="card-header d-sm-flex d-block pb-0 border-0">
                        <div class="me-auto pe-3">
                            <h4 class="text-black fs-20">Calories Chart</h4>
                            <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
                        </div>
                        <div class="dropdown mt-sm-0 mt-3">
                            <button type="button" class="btn rounded border border-light dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Weekly
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="javascript:void(0);">Link 1</a>
                                <a class="dropdown-item" href="javascript:void(0);">Link 2</a>
                                <a class="dropdown-item" href="javascript:void(0);">Link 3</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div id="chartTimeline"></div>
                    </div>
                </div>
            </div> -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-sm-flex d-block pb-0 border-0">
                        <div class="me-auto pe-3">
                            <h4 class="text-black fs-20">Featured Diet Menus</h4>
                            <p class="fs-13 mb-0 text-black">Lorem ipsum dolor sit amet, consectetur</p>
                        </div>
                        <div class="card-action card-tabs mt-3 mt-sm-0 mt-3 mb-sm-0 mb-3 mt-sm-0 me-0 me-md-5">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#Breakfast" role="tab">
                                        Breakfast
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#Lunch" role="tab">
                                        Lunch
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#Dinner" role="tab">
                                        Dinner
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <a href="food-menu.html" class="btn btn-primary rounded d-none d-md-block">View More</a>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="Breakfast" role="tabpanel">
                                <div class="featured-menus owl-carousel">
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/3.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/3.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Ilham</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Sweet Orange Fruits with Lemon</a></h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">176 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/1.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/1.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Andrew</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Fresh or Frozen (No Sugar Added) Fruits</a>
                                                </h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">568 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/1.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/1.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Andrew</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Fresh or Frozen (No Sugar Added) Fruits</a>
                                                </h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">568 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/2.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/2.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Chintya</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Chicken Egg with fresh tomatos</a></h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">223 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Lunch" role="tabpanel">
                                <div class="featured-menus owl-carousel">
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/1.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/1.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Andrew</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Fresh or Frozen (No Sugar Added) Fruits</a>
                                                </h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">568 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/3.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/3.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Ilham</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Sweet Orange Fruits with Lemon</a></h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">176 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/2.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/2.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Chintya</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Chicken Egg with fresh tomatos</a></h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">223 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/1.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/1.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Andrew</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Fresh or Frozen (No Sugar Added) Fruits</a>
                                                </h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">568 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="Dinner" role="tabpanel">
                                <div class="featured-menus owl-carousel">
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/1.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/1.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Andrew</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Fresh or Frozen (No Sugar Added) Fruits</a>
                                                </h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">568 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/2.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/2.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Chintya</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Chicken Egg with fresh tomatos</a></h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">223 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/3.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/3.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Ilham</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Sweet Orange Fruits with Lemon</a></h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">176 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="items">
                                        <div class="d-sm-flex p-3 border border-light rounded">
                                            <a href="ecom-product-detail.html"><img class="me-4 food-image rounded"
                                                    src="public/images/menus/1.png" alt="" width="160"></a>
                                            <div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <img class="rounded-circle me-2 profile-image"
                                                        src="public/images/testimonial/1.jpg" alt="" width="30">
                                                    <span class="fs-14 text-primary">Andrew</span>
                                                </div>
                                                <h6 class="fs-16 mb-4"><a href="ecom-product-detail.html"
                                                        class="text-black">Fresh or Frozen (No Sugar Added) Fruits</a>
                                                </h6>
                                                <ul>
                                                    <li class="mb-2"><i class="las la-clock scale5 me-3"></i><span
                                                            class="fs-14 text-black">4-6 mins </span></li>
                                                    <li><i class="fa fa-star me-3 scale5 text-warning"
                                                            aria-hidden="true"></i><span
                                                            class="fs-14 text-black font-w500">568 Reviews</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
                                            Content body end
                                ***********************************-->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


<!-- <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data for the current week (for example purposes, you should fetch real data dynamically)
        let labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        let presentData = [30, 25, 40, 35, 50, 45, 60]; // Present users for each day
        let absentData = [10, 15, 5, 20, 10, 5, 10];   // Absent users for each day

        // Calculate percentages
        let totalUsers = presentData.map((present, index) => present + absentData[index]);
        let presentPercentage = (presentData.reduce((a, b) => a + b) / totalUsers.reduce((a, b) => a + b)) * 100;
        let absentPercentage = (absentData.reduce((a, b) => a + b) / totalUsers.reduce((a, b) => a + b)) * 100;

        document.getElementById('presentPercentage').innerText = `${presentPercentage.toFixed(0)}%`;
        document.getElementById('absentPercentage').innerText = `${absentPercentage.toFixed(0)}%`;

        // Initialize Chart.js
        var ctx = document.getElementById('attendanceChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Present',
                        data: presentData,
                        borderColor: '#FF9432',
                        fill: false,
                        tension: 0.1,
                        borderWidth: 3,  // Make the line bold
                        pointRadius: 6,  // Increase dot size
                        pointBackgroundColor: '#FF9432'  // Bold point color
                    },
                    {
                        label: 'Absent',
                        data: absentData,
                        borderColor: '#1EA7C5',
                        fill: false,
                        tension: 0.1,
                        borderWidth: 3,  // Make the line bold
                        pointRadius: 6,  // Increase dot size
                        pointBackgroundColor: '#1EA7C5'  // Bold point color
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Users',
                            font: {
                                size: 14,
                                weight: 'bold'  // Make the y-axis title bold
                            }
                        },
                        ticks: {
                            font: {
                                weight: 'bold'  // Make y-axis labels bold
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Week Days',
                            font: {
                                size: 14,
                                weight: 'bold'  // Make the x-axis title bold
                            }
                        },
                        ticks: {
                            font: {
                                weight: 'bold'  // Make x-axis labels bold
                            }
                        }
                    }
                }
            }
        });
    });
</script> -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize chart variables
        let attendanceChart;

        // Function to update chart with new data
        function updateChart(presentData, absentData, presentPercentage, absentPercentage) {

            // Set present and absent percentage in the UI
            document.getElementById('presentPercentage').innerText = presentPercentage + '%';
            document.getElementById('absentPercentage').innerText = absentPercentage + '%';

            let labels = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

            let ctx = document.getElementById('attendanceChart').getContext('2d');

            if (attendanceChart) {
                // If chart already exists, update it
                attendanceChart.data.datasets[0].data = presentData;
                attendanceChart.data.datasets[1].data = absentData;
                attendanceChart.update();
            } else {
                // Create new chart if it doesn't exist
                attendanceChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [
                            {
                                label: 'Present',
                                data: presentData,
                                borderColor: '#FF9432',
                                fill: false,
                                tension: 0.1,
                                borderWidth: 3,  // Make the line bold
                                pointRadius: 6,  // Increase dot size
                                pointBackgroundColor: '#FF9432'  // Bold point color
                            },
                            {
                                label: 'Absent',
                                data: absentData,
                                borderColor: '#1EA7C5',
                                fill: false,
                                tension: 0.1,
                                borderWidth: 3,  // Make the line bold
                                pointRadius: 6,  // Increase dot size
                                pointBackgroundColor: '#1EA7C5'  // Bold point color
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Number of Users',
                                    font: {
                                        size: 14,
                                        weight: 'bold'  // Make the y-axis title bold
                                    }
                                },
                                ticks: {
                                    font: {
                                        weight: 'bold'  // Make y-axis labels bold
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Week Days',
                                    font: {
                                        size: 14,
                                        weight: 'bold'  // Make the x-axis title bold
                                    }
                                },
                                ticks: {
                                    font: {
                                        weight: 'bold'  // Make x-axis labels bold
                                    }
                                }
                            }
                        }
                    }
                });
            }
        }

        // AJAX request to fetch data
        function fetchAttendanceData() {
            $.ajax({
                url: '/user-attendance-chart', // Replace with your route to fetch data
                method: 'GET',
                success: function (response) {
                    // Assuming the response contains present and absent data
                    let presentData = Object.values(response.present);
                    let absentData = Object.values(response.absent);
                    let presentPercentage = response.presentPercentage;
                    let absentPercentage = response.absentPercentage;

                    // Update the chart with new data
                    updateChart(presentData, absentData, presentPercentage, absentPercentage);
                },
                error: function (error) {
                    console.error('Error fetching attendance data:', error);
                }
            });
        }

        // Fetch the data once the page is loaded
        fetchAttendanceData();

        const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
        const currentDate = new Date();
        const currentMonth = monthNames[currentDate.getMonth()];
        document.getElementById("monthDropdown").innerHTML = currentMonth;

    });

    document.addEventListener('DOMContentLoaded', function () {
        // Make an AJAX request to fetch today's attendance
        $.ajax({
            url: "{{ route('user-today-attendance') }}",
            type: 'GET',
            success: function (data) {
                // Get the present percentage from the response
                let presentPercentage = data.presentPercentage;

                // Render the radial bar chart using the fetched percentage
                renderRadialBar(presentPercentage);
            },
            error: function (xhr, status, error) {
                console.error('Error fetching attendance data:', error);
            }
        });

        // Function to render the radial bar chart
        function renderRadialBar(presentPercentage) {
            var options = {
                series: [presentPercentage],
                chart: {
                    type: 'radialBar',
                    height: 300,
                    offsetY: -10
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -135,
                        endAngle: 135,
                        dataLabels: {
                            name: {
                                fontSize: '16px',
                                color: undefined,
                                offsetY: 120
                            },
                            value: {
                                offsetY: 0,
                                fontSize: '34px',
                                color: 'black',
                                formatter: function (val) {
                                    return val + "%";
                                }
                            }
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    colors: '#6EC51E',
                    gradient: {
                        shade: 'dark',
                        shadeIntensity: 0.15,
                        inverseColors: false,
                        opacityFrom: 1,
                        opacityTo: 1,
                        stops: [0, 50, 65, 91]
                    },
                },
                stroke: {
                    dashArray: 4,
                    colors: '#6EC51E'
                },
                labels: ['Present Users'],
                colors: ['#FF9432']
            };

            var chart = new ApexCharts(document.querySelector("#userRadialBar"), options);
            chart.render();
        }
    });
</script>

@endsection