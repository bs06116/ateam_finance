@extends('layouts.default')
@section('title', '| Project Managers')
@section('bodyClass', '__job-list-page')

@section('head')
    @parent
    <!-- Custom head here -->
    <link href="{{ url('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />

@endsection


@section('main_content')
    <div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">

        <!-- begin:: Content Head -->
        <div class="kt-subheader   kt-grid__item" id="kt_subheader" style="background-color: transparent;">
            <div class="kt-container  kt-container--fluid ">
                <div class="kt-subheader__main">
                    <div class="kt-subheader__group" id="kt_subheader_search">
                        <form class="" id="kt_subheader_search_form">
                            <div class="kt-input-icon kt-input-icon--left">
                                <input type="text" class="radius form-control" placeholder="Search Here" id="generalSearch">
                                <span class="kt-input-icon__icon kt-input-icon__icon--left">
                                    <span><i class="la la-search"></i></span>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="kt-subheader__toolbar">
                    <a href="#" class="">
                    </a>
                    <a href="#" class="radius btn btn-brand btn-elevate btn-pill" data-toggle="modal" data-target="#modalAdd">
                        ADD NEW
                    </a>
                </div>
            </div>
        </div>

        <!-- end:: Content Head -->

        <!-- begin:: Content -->
        <div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">

            <!--begin::Portlet-->
<!--             <div class="portletTable kt-portlet kt-portlet--mobile">
                <div class="kt-portlet__body kt-portlet__body--fit">
 -->
                    <!--begin: Datatable -->
                    <div class="kt-datatable" id="kt_apps_user_list_datatable"></div>

                    <!--end: Datatable -->
<!--                 </div>
            </div>
 -->
            <!--end::Portlet-->

            <!--begin::Modal-->
            <div class="modal fade" id="kt_datatable_records_fetch_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Selected Records</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="kt-scroll" data-scroll="true" data-height="200">
                                <ul id="kt_apps_user_fetch_records_selected"></ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-brand" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--end::Modal-->
        </div>

        <!-- end:: Content -->
    </div>

    <!--begin::Modal-->
    <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="kt-grid kt-wizard-v1 kt-wizard-v1--white" id="add_new_projet_step" data-ktwizard-state="step-first">

                        <div class="kt-heading text-center kt-heading--md text-uppercase">Add New Project</div>

                        <div class="kt-grid__item d-none">

                            <!--begin: Form Wizard Nav -->
                            <div class="kt-wizard-v1__nav">
                                <!--doc: Remove "kt-wizard-v1__nav-items--clickable" class and also set 'clickableSteps: false' in the JS init to disable manually clicking step titles -->
                                <div class="kt-wizard-v1__nav-items">
                                    <div class="kt-wizard-v1__nav-item" data-ktwizard-type="step" data-ktwizard-state="current">
                                        1
                                    </div>
                                    <div class="kt-wizard-v1__nav-item" data-ktwizard-type="step">
                                        2
                                    </div>
                                </div>
                            </div>

                            <!--end: Form Wizard Nav -->
                        </div>
                        <div class="kt-grid__item kt-grid__item--fluid kt-wizard-v1__wrapper">

                            <!--begin: Form Wizard Form-->
                            <form class="kt-form" id="add_new_projet_form" method="POST">
                                @csrf
                                <!--begin: Form Wizard Step 1-->
                                <div class="kt-wizard-v1__content" data-ktwizard-type="step-content" data-ktwizard-state="current">
                                    <div class="text-right">STEP 1/2</div>
                                    <div class="kt-form__section kt-form__section--first">
                                        <div class="kt-wizard-v1__form">
                                            <div class="form-group">
                                                <label>Project Name</label>
                                                <input type="text" class="form-control" name="_ip_add_project_name" placeholder="Your project name">
                                            </div>
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea type="text" class="form-control" name="_ip_add_des" placeholder="Your description" rows="4"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Assigned a Project Manager</label>
                                                <select class="form-control kt-select2" id="_ip_add_pm" name="_ip_add_pm" multiple>
                                                    @foreach($projectManagers as $projectManager)
                                                        <option value="{{$projectManager->id}}">{{$projectManager->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Assigned a Project Foreman</label>
                                                <select class="form-control kt-select2" id="_ip_add_pf" name="_ip_add_pf" multiple>
                                                    @foreach($foremans as $foreman)

                                                        <option value="{{$foreman->id}}">{{$foreman->name}}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 1-->

                                <!--begin: Form Wizard Step 2-->
                                <div class="kt-wizard-v1__content" data-ktwizard-type="step-content">
                                    <div class="text-right">STEP 2/2</div>
                                    <div class="kt-form__section kt-form__section--first">
                                        <div class="kt-wizard-v1__form">
                                            <div class="form-group">
                                                <label>Add Employee</label>
                                                <select class="form-control kt-select2" id="_ip_add_employee" name="_ip_add_employee[]" multiple="multiple">
                                                    @foreach($employees as $employee)
                                                        <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Assigned Cost Codes</label>
                                                <strong class="float-right"><a href="#">Cost Code Library</a></strong>
                                                <select class="form-control kt-select2" id="_ip_add_cost_codes" name="_ip_add_cost_codes[]" multiple="multiple">
                                                                            <?php

$conn = mysqli_connect('localhost','root','','ateamthe_ateam');
                                                                            $queryapp = "SELECT * FROM cost_codes ORDER by id ASC";
                                                                            $query_app = mysqli_query($conn,$queryapp);
                                                                            while($cost_codes = mysqli_fetch_array($query_app)) {
                                                                            ?>
                                                                            <option value="<?php echo $cost_codes['id'];?>"><?php echo $cost_codes['id'];?> <?php echo $cost_codes['name'];?></option>
                                                                            <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Assigned Paygroups</label>
                                                <strong class="float-right"><a href="#">Paygroups Library</a></strong>
                                                <select class="form-control kt-select2" id="_ip_add_paygroups" name="_ip_add_paygroups[]" multiple="multiple">
                                                    @foreach($paygroups as $paygroup)
                                                        <option value="{{$paygroup->id}}">{{$paygroup->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <input type="text" class="form-control" id="_ip_add_start_date" name="_ip_add_start_date" readonly placeholder="Select date" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end: Form Wizard Step 2-->

                                <!--begin: Form Actions -->
                                <div class="kt-form__actions">
                                    <button class="btn btn-cancel btn-pill btn-secondary btn-tall kt-font-bold kt-font-transform-u mr-1 w-100" data-dismiss="modal">Cancel</button>
                                    <button class="btn btn-secondary btn-md btn-pill btn-tall btn-wide kt-font-bold kt-font-transform-u mr-1 w-100" data-ktwizard-type="action-prev">
                                        Previous
                                    </button>
                                    <button class="btn btn-brand btn-md btn-pill btn-tall btn-wide kt-font-bold kt-font-transform-u ml-1 w-100" data-ktwizard-type="action-submit"  data-dismiss="modal">
                                        Create Project
                                    </button>
                                    <button class="btn btn-brand btn-pill btn-tall kt-font-bold kt-font-transform-u ml-1 w-100" data-ktwizard-type="action-next">
                                        Next
                                    </button>
                                </div>

                                <!--end: Form Actions -->
                            </form>

                            <!--end: Form Wizard Form-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('body_last')
    <script src="{{ url('js/jobsList.js') }}" type="text/javascript"></script>
@endsection
