@extends('GymOwner.master')
@section('title','Dashboard')
@section('content')

<div class="content-body">
    <!-- container starts -->
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item"><a href="javascript:void(0)">Bootstrap</a></li> --}}
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Terms And Conditions</a></li>
            </ol>
        </div>
        <!-- row -->
        <!-- Row starts -->
        <div class="row">
            <!-- Column starts -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h4 class="card-title">Terms And Conditions</h4>
                        {{-- <p class="m-0 subtitle">Default accordion. Add <code>accordion</code> class in root</p> --}}
                    </div>
                    <div class="card-body">
                        <div class="accordion accordion-primary" id="accordion-one">
                              <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#default-collapseOne" aria-expanded="true" aria-controls="default-collapseOne">
                                    1. Applicability
                                  </button>
                                </h2>
                                <div id="default-collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordion-one">
                                  <div class="accordion-body">
                                    1.1 The General Terms and Conditions below apply to all offers and transactions of Wingers IT Services. Prices are subject to change.</br>
                                    1.2 By accepting an offer or making an order, the consumer expressly accepts the applicability of these General Terms and Conditions.</br>
                                    1.3 Deviations from that stipulated in these Terms and Conditions are only valid when they are confirmed in writing by the management.</br>
                                    1.4 All rights and entitlements stipulated for Wingers IT Services in these General Terms and Conditions and any further agreements will also apply for intermediaries and other third parties deployed by Wingers IT services.
                                  </div>
                                </div>
                              </div>
                              <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#default-collapseTwo" aria-expanded="false" aria-controls="default-collapseTwo">
                                    2.QUALITY
                                  </button>
                                </h2>
                                <div id="default-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordion-one">
                                  <div class="accordion-body">
                                    2.1 The Application guarantees that all the products i.e marriage offers, jobs,business and events mentioned meets the standards of the concept.</br>
                                    2.2 If there are any complaints the management needs to be informed immediately. Appropriate actions will be taken as soon as possible.
                                  </div>
                                </div>
                              </div>
                              <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#default-collapseThree" aria-expanded="false">
                                    3. Prices/offers
                                  </button>
                                </h2>
                                <div id="default-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordion-one">
                                  <div class="accordion-body">
                                    3.1 All offers made by Wingers IT Services are without obligation and we expressly reserves the right to change the prices, in particular if this is necessary as a result of statutory or other regulations.</br>
3.2 All prices are indicated in Rupees, including GST.</br>
3.3 In certain cases, promotional prices apply. These prices are valid only during a specific period as long as stocks last. No entitlement to these prices may be invoked before or after the specific period.</br>
3.4 Wingers IT Services cannot be held to any price indications that are clearly incorrect, for example as a result of obvious typesetting or printing errors. No rights may be derived from incorrect price information.</br>
3.5 In case of any variation in invoice , Wingers IT Services will not be held responsible. Users / Customers need to verify the same from The management of the WITS GYM.</br>
                                </div>
                                </div>
                              </div>
                               <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#default-collapseFour" aria-expanded="false" aria-controls="default-collapseFour">
                                    4. Payments
                                  </button>
                                </h2>
                                <div id="default-collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordion-one">
                                  <div class="accordion-body">
                                    4.1 All prices are including GST.</br>
                                    4.2 Methods of payment we accept: Cash and Online via gpay, Paytm,etc.</br>
                                    4.3 You will not receive confirmation of your definitive booking until your payment has been approved.
                                  </div>
                                </div>
                              </div>

                              <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#default-collapseFour" aria-expanded="false" aria-controls="default-collapseFour">
                                    5. Other provisions
                                  </button>
                                </h2>
                                <div id="default-collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordion-one">
                                  <div class="accordion-body">
                                    5.1 If one or more of the provisions in these Terms and Conditions or any other agreement with Wingers IT Services are in conflict with any applicable legal regulation, the provision in question will lapse and be replaced by a new comparable stipulation admissible by law to be determined by Wingers IT Services.</br>
                                    5.2 The law of India applies to all agreements entered into with or concluded by Wingers IT Services. Any disputes arising directly or indirectly from these agreements will be exclusively settled by the Court of India.
                                  </div>
                                </div>
                              </div>

                              <div class="accordion-item">
                                <h2 class="accordion-header">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#default-collapseFour" aria-expanded="false" aria-controls="default-collapseFour">
                                    6. Cancellations
                                  </button>
                                </h2>
                                <div id="default-collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordion-one">
                                  <div class="accordion-body">
                                    6.1 If an event is cancelled or postponed, we will do its utmost to inform you as soon as possible. However, Wingers IT Services will not be responsible for the same .
                                     Customers need to verify the same with the management of that particular event.
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column ends -->

        </div>
        <!-- Row ends -->
    </div>
    <!-- container ends -->
</div>





@endsection
