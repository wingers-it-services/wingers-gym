@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<div class="content-body ">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">FAQ</a></li>

            </ol>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header" id="cardHeader1">
                        <h5 class="card-title">How can I Add, Update , Delete Plans?</h5>
                    </div>
                    <div class="card-body" id="cardBody1" style="display: none;">
                        <p class="card-text">
                            Adding an Plans:
                        <ol>
                            <li>1. Click on the "Add New Subscription" button at the upper right side of the table.</li>
                            <li>2. A pop-up input box will appear for Adding the Subscription.</li>
                            <li>3. Enter the Subscription name , Validity(in months) ,Subscription Price ,Plan Start Date,Plan Description and click on "Submit".</li>
                            <li>4. The New Subscription will be added and listed in the table.</li>
                        </ol>
                        Updating an Plans: <br><br>
                        <ol>
                            <li>1. Click on the edit icon in the individual row of the Subscription you wish to update.</li>
                            <li>2. Edit the Subscription name , Validity(in months) ,Subscription Price ,Plan Start Date,Plan Description in the same manner as you added it.</li>
                            <li>3. Save your changes, and the updated Subscription will be reflected in the table.</li>
                        </ol>
                        Deleting an Plans: <br><br>
                        <ol>
                            <li>1. Click on the delete icon in the individual row of the Subscription you wish to delete.</li>
                            <li>2. It ask for a confirmation . If you want to delete then confirm it . </li>

                        </ol>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header" id="cardHeader2">
                        <h5 class="card-title">How can I add, update, delete and view add gym workout?</h5>
                    </div>
                    <div class="card-body" id="cardBody2" style="display: none;">
                        <p class="card-text">
                            Adding an Add Gym Workout:
                        <ol>
                            <li>1. Click on the "Add Gym Workout" in menu bar .</li>
                            <li>2. A form will open in which you have to fill the give fields .</li>
                            <li>3.Then Click on Add workout Button .</li>
                            <li>4. The new added gym workout will be added and listed in the table.</li>
                        </ol>
                        Updating an Gym Workout: <br><br>
                        <ol>
                            <li>1. Click on the edit icon in the individual row of the  workout you wish to update.</li>
                            <li>2. Edit those fields which you want to update .</li>
                            <li>3. Save your changes, and the updated workout will be reflected in the table.</li>
                        </ol>
                        Deleting an Gym Workout: <br><br>
                        <ol>
                            <li>1. Click on the delete icon in the individual row of the workout you wish to delete.</li>
                            <li>2. It ask for a confirmation .</li>
                            <li>3. If you want to delete then confirm it . </li>
                        </ol>
                        View an Gym Workout: <br><br>
                        <ol>
                            <li>1. Click on the View icon in the individual row of the  workout you wish to view the details.</li>

                        </ol>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header" id="cardHeader3">
                        <h5 class="card-title">How can I add, update, delete and view add gym diet?</h5>
                    </div>
                    <div class="card-body" id="cardBody3" style="display: none;">
                        <p class="card-text">
                            Adding an  Diet:
                            <ol>
                                <li>1. Click on the "Add Gym Diet" in menu bar .</li>
                                <li>2. A form will open in which you have to fill the give fields .</li>
                                <li>3.Then Click on Add Diet Button .</li>
                                <li>4. The new added gym Diet will be added and listed in the table.</li>
                            </ol>
                            Updating an Diet: <br><br>
                            <ol>
                                <li>1. Click on the edit icon in the individual row of the  Diet you wish to update.</li>
                                <li>2. Edit those fields which you want to update .</li>
                                <li>3. Save your changes, and the updated Diet will be reflected in the table.</li>
                            </ol>
                            Deleting an Diet: <br><br>
                            <ol>
                                <li>1. Click on the delete icon in the individual row of the Diet you wish to delete.</li>
                                <li>2. It ask for a confirmation .</li>
                                <li>3. If you want to delete then confirm it . </li>
                            </ol>
                            View an Diet: <br><br>
                            <ol>
                                <li>1. Click on the View icon in the individual row of the  Diet you wish to view the details.</li>

                            </ol>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header" id="cardHeader4">
                        <h5 class="card-title">How can I Add GYM Staff?</h5>
                    </div>
                    <div class="card-body" id="cardBody4" style="display: none;">
                        <p class="card-text">
                            To Add Gym staff:
                        <ol>
                            <li>1. Click on the "Gym Staff" menu in the menu bar.</li>
                            <li>2. A dropdown menu will open. Click on the "Add New Staff" sub-menu.</li>
                            <li>3. An "Add Staff Details" form will appear.</li>
                            <li>4. Fill in the basic details of the staff, such as Image, Employee Id,Full Name,Email Address,Phone Number,
                                Joining Date, Salary,Designation,Blood Group, Address.</li>
                            <li>5. Click on the "Submit" button. The staff will be added.</li>
                            <li>6. To view the newly added staff, click on the "staff List" sub-menu in the "Gym Staff" menu.</li>
                        </ol>
                        </p>
                        <p class="card-text">
                            To staff List:
                        <ol>

                            <li>1. In the dropdown menu there is a option of staff list where  the data of all staff will be listed .</li>

                        </ol>
                        </p>
                        <p class="card-text">
                            To staff edit:
                        <ol>
                            <li>1. In staff List there is a option of edit staff in every individual row.</li>
                            <li>2. Click on edit icon . Edit Those Fields .</li>
                            <li>3. Click on the "Update" button. The staff will be Updated.</li>

                        </ol>
                        </p>
                        <p class="card-text">
                            To staff details:
                        <ol>
                            <li>1. In the dropdown menu there is a option of staff details . where the Staff details is visible. </li>
                            <li>2.Click on any Staff to see it's details.</li>
                            <li>3.You also mark the attendance of the staff.</li>
                        </ol>
                        </p>
                        <p class="card-text">
                            To Add Designation:
                            <ol>
                                <li>1. Click on the "Add New Designation" button at the upper right side of the table.</li>
                                <li>2. A pop-up input box will appear for Adding the Designation.</li>
                                <li>3. Enter the Designation and click on "Submit".</li>
                                <li>4. The New Designation will be added and listed in the table.</li>
                            </ol>
                            Updating an Plans: <br><br>
                            <ol>
                                <li>1. Click on the edit icon in the individual row of the Designation you wish to update.</li>
                                <li>2. Edit the  Designation name in the same manner as you added it.</li>
                                <li>3. Save your changes, and the updated Designation will be reflected in the table.</li>
                            </ol>
                            Deleting an Plans: <br><br>
                            <ol>
                                <li>1. Click on the delete icon in the individual row of the Designation you wish to delete.</li>
                                <li>2. It ask for a confirmation . If you want to delete then confirm it . </li>

                            </ol>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header" id="cardHeader5">
                        <h5 class="card-title">How can I minimize my navbar?</h5>
                    </div>
                    <div class="card-body" id="cardBody5" style="display: none;">
                        <p class="card-text">
                            To minimize your navbar:
                        <ol>
                            <li>1. Click on the three horizontal lines located beside the main navbar at the upper left side of the page.</li>
                            <li>2. To restore the navbar, click on the three horizontal lines again.</li>
                        </ol>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header" id="cardHeader6">
                        <h5 class="card-title">How can I change the dark theme mode of the web page.</h5>
                    </div>
                    <div class="card-body" id="cardBody6" style="display: none;">
                        <p class="card-text">
                            To change the theme mode of the web page:
                        <ol>
                            <li>1. Click on the sun symbol beside the user profile to switch to dark theme mode.</li>
                            <li>2. To switch back to light theme mode, click on the moon symbol.</li>
                        </ol>
                        </p>
                    </div>
                </div>
            </div>


            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header" id="cardHeader7">
                        <h5 class="card-title">How can I view the payment details of all users?</h5>
                    </div>
                    <div class="card-body" id="cardBody7" style="display: none;">
                        <p class="card-text">
                            To view the payment details of all users:
                        <ol>
                            <li>1. Click on the "Payment Details" sub-menu under the "Users" menu.</li>
                            <li>2. You will see a list of users with details including their name, email, contact number, payment date, and payment status.</li>
                        </ol>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header" id="cardHeader8">
                        <h5 class="card-title">How can I add the Advertisments?</h5>
                    </div>
                    <div class="card-body" id="cardBody8" style="display: none;">
                        <p class="card-text">
                            To add advertisements:
                        <ol>
                            <li>1. Click on the "Advertisements" menu in the menu bar.</li>
                            <li>2. Click on the "Add Advertisement" button at the upper right side of the table.</li>
                            <li>3. A pop-up input box will appear. Upload the advertisement image and select the image type (horizontal or vertical).</li>
                            <li>4. Click on the "Save" button.</li>
                            <li>5. The advertisement will be added successfully and listed in the table. It will also be displayed to user on the industry list page.</li>
                        </ol>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header" id="cardHeader9">
                        <h5 class="card-title">How can I view all users login history?</h5>
                    </div>
                    <div class="card-body" id="cardBody9" style="display: none;">
                        <p class="card-text">
                            To view login history of all users:
                        <ol>
                            <li>1. Click on the "User Login History" menu.</li>
                            <li>2. You will see a list of login histories for all users, including their names, email addresses, device types used for logging in, IP addresses, login dates, and the cities and states from which they logged in, among other details.</li>
                        </ol>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header" id="cardHeader10">
                        <h5 class="card-title">How can I view and update my profile?</h5>
                    </div>
                    <div class="card-body" id="cardBody10" style="display: none;">
                        <p class="card-text">
                            To view and update your profile:
                        <ol>
                            <li>1. Go to the right side corner of the page where you can see your profile image.</li>
                            <li>2. Click on your profile image to open a dropdown menu.</li>
                            <li>3. Click on "Profile" to view your profile page.</li>
                            <li>4. FOn the profile page, you can make changes to update your profile.</li>
                        </ol>
                        </p>
                    </div>
                </div>
            </div>


        </div>

    </div>
</div>

<script>
    function toggleCardBody(cardBodyId) {
        const cardBody = document.getElementById(cardBodyId);
        if (cardBody.style.display === 'none' || cardBody.style.display === '') {
            cardBody.style.display = 'block';
        } else {
            cardBody.style.display = 'none';
        }
    }

    document.getElementById('cardHeader1').addEventListener('click', function() {
        toggleCardBody('cardBody1');
    });

    document.getElementById('cardHeader2').addEventListener('click', function() {
        toggleCardBody('cardBody2');
    });

    document.getElementById('cardHeader3').addEventListener('click', function() {
        toggleCardBody('cardBody3');
    });

    document.getElementById('cardHeader4').addEventListener('click', function() {
        toggleCardBody('cardBody4');
    });

    document.getElementById('cardHeader5').addEventListener('click', function() {
        toggleCardBody('cardBody5');
    });

    document.getElementById('cardHeader6').addEventListener('click', function() {
        toggleCardBody('cardBody6');
    });

    document.getElementById('cardHeader7').addEventListener('click', function() {
        toggleCardBody('cardBody7');
    });

    document.getElementById('cardHeader8').addEventListener('click', function() {
        toggleCardBody('cardBody7');
    });

    document.getElementById('cardHeader9').addEventListener('click', function() {
        toggleCardBody('cardBody7');
    });

    document.getElementById('cardHeader10').addEventListener('click', function() {
        toggleCardBody('cardBody7');
    });
</script>




@endsection
