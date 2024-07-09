@extends('admin.master')
@section('title', 'Dashboard')
@section('content')
    <!--**********************************
                            Content body start
                        ***********************************-->
    <div class="content-body ">
        <div class="container-fluid">
            <div class="page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Payment</a></li>
                </ol>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display min-w850">
                                    <thead>
                                        <tr>
                                            <th class="align-middle">Order</th>
                                            <th class="align-middle pe-7">Date</th>
                                            <th class="align-middle" style="min-width: 12.5rem;">Address</th>
                                            <th class="align-middle text-end">Status</th>
                                            <th class="align-middle text-end">Amount</th>
                                            <th class="align-middle text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="orders">
                                        <tr class="btn-reveal-trigger">
                                            <td class="py-2">
                                                <strong class="text-primary">#181</strong> by
                                                <br> <strong class="text-primary">Ricky
                                                    Antony</strong>
                                            </td>
                                            <td class="py-2">20/04/2020</td>
                                            <td class="py-2">Ricky Antony, 2392 Main Avenue, Penasauka, New Jersey 02149
                                                <p class="mb-0 text-500">Via Flat Rate</p>
                                            </td>
                                            <td class="py-2 text-end"><span
                                                    class="badge badge-success badge-sm light">Completed<span
                                                        class="ms-1 fa fa-check"></span></span>
                                            </td>
                                            <td class="py-2 text-end">$99
                                            </td>
                                            <td class="py-2 text-end">
                                                <div class="dropdown text-sans-serif"><button
                                                        class="btn btn-primary tp-btn-light sharp" type="button"
                                                        id="order-dropdown-0" data-bs-toggle="dropdown"
                                                        data-boundary="viewport" aria-haspopup="true"
                                                        aria-expanded="false"><span><svg xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"
                                                                height="18px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24"></rect>
                                                                    <circle fill="#000000" cx="5" cy="12"
                                                                        r="2"></circle>
                                                                    <circle fill="#000000" cx="12" cy="12"
                                                                        r="2"></circle>
                                                                    <circle fill="#000000" cx="19" cy="12"
                                                                        r="2"></circle>
                                                                </g>
                                                            </svg></span></button>
                                                    <div class="dropdown-menu dropdown-menu-end border py-0"
                                                        aria-labelledby="order-dropdown-0">
                                                        <div class="py-2"><a class="dropdown-item"
                                                                href="javascript:void(0);">Completed</a><a
                                                                class="dropdown-item"
                                                                href="javascript:void(0);">Processing</a><a
                                                                class="dropdown-item" href="javascript:void(0);">On
                                                                Hold</a><a class="dropdown-item"
                                                                href="javascript:void(0);">Pending</a>
                                                            <div class="dropdown-divider"></div><a
                                                                class="dropdown-item text-danger"
                                                                href="javascript:void(0);">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="btn-reveal-trigger">
                                            <td class="py-2">
                                                <a href="#">
                                                    <strong class="text-primary">#182</strong></a> by <strong
                                                    class="text-primary">Kin Rossow</strong><br><a
                                                    href="https://fito.dexignzone.com/cdn-cgi/l/email-protection#85eeecebc5e0fde4e8f5e9e0abe6eae8"><span
                                                        class="__cf_email__"
                                                        data-cfemail="4c2725220c29342d213c2029622f2321">[email&#160;protected]</span></a>
                                            </td>
                                            <td class="py-2">20/04/2020</td>
                                            <td class="py-2">Kin Rossow, 1 Hollywood Blvd,Beverly Hills, California 90210
                                                <p class="mb-0 text-500">Via Free Shipping
                                                </p>
                                            </td>
                                            <td class="py-2 text-end"><span
                                                    class="badge badge-primary badge-sm light">Processing<span
                                                        class="ms-1 fa fa-redo"></span></span>
                                            </td>
                                            <td class="py-2 text-end">$120
                                            </td>
                                            <td class="py-2 text-end">
                                                <div class="dropdown text-sans-serif"><button
                                                        class="btn btn-primary tp-btn-light sharp" type="button"
                                                        id="order-dropdown-1" data-bs-toggle="dropdown"
                                                        data-boundary="viewport" aria-haspopup="true"
                                                        aria-expanded="false"><span><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"
                                                                height="18px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24">
                                                                    </rect>
                                                                    <circle fill="#000000" cx="5" cy="12"
                                                                        r="2"></circle>
                                                                    <circle fill="#000000" cx="12" cy="12"
                                                                        r="2"></circle>
                                                                    <circle fill="#000000" cx="19" cy="12"
                                                                        r="2"></circle>
                                                                </g>
                                                            </svg></span></button>
                                                    <div class="dropdown-menu dropdown-menu-end border py-0"
                                                        aria-labelledby="order-dropdown-1">
                                                        <div class="py-2"><a class="dropdown-item"
                                                                href="javascript:void(0);">Completed</a><a
                                                                class="dropdown-item"
                                                                href="javascript:void(0);">Processing</a><a
                                                                class="dropdown-item" href="javascript:void(0);">On
                                                                Hold</a><a class="dropdown-item"
                                                                href="javascript:void(0);">Pending</a>
                                                            <div class="dropdown-divider"></div><a
                                                                class="dropdown-item text-danger"
                                                                href="javascript:void(0);">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="btn-reveal-trigger">
                                            <td class="py-2">
                                                <a href="#">
                                                    <strong class="text-primary">#183</strong></a> by <strong
                                                    class="text-primary">Merry
                                                    Diana</strong><br><a
                                                    href="https://fito.dexignzone.com/cdn-cgi/l/email-protection#432e2631313a03263b222e332f266d202c2e"><span
                                                        class="__cf_email__"
                                                        data-cfemail="7a171f0808033a1f021b170a161f54191517">[email&#160;protected]</span></a>
                                            </td>
                                            <td class="py-2">30/04/2020</td>
                                            <td class="py-2">Merry Diana, 1 Infinite Loop, Cupertino, California 90210
                                                <p class="mb-0 text-500">Via Link Road</p>
                                            </td>
                                            <td class="py-2 text-end"><span
                                                    class="badge badge-secondary badge-sm light">On
                                                    Hold<span class="ms-1 fa fa-ban"></span></span>
                                            </td>
                                            <td class="py-2 text-end">$70
                                            </td>
                                            <td class="py-2 text-end">
                                                <div class="dropdown text-sans-serif"><button
                                                        class="btn btn-primary tp-btn-light sharp" type="button"
                                                        id="order-dropdown-2" data-bs-toggle="dropdown"
                                                        data-boundary="viewport" aria-haspopup="true"
                                                        aria-expanded="false"><span><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"
                                                                height="18px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24">
                                                                    </rect>
                                                                    <circle fill="#000000" cx="5" cy="12"
                                                                        r="2"></circle>
                                                                    <circle fill="#000000" cx="12" cy="12"
                                                                        r="2"></circle>
                                                                    <circle fill="#000000" cx="19" cy="12"
                                                                        r="2"></circle>
                                                                </g>
                                                            </svg></span></button>
                                                    <div class="dropdown-menu dropdown-menu-end border py-0"
                                                        aria-labelledby="order-dropdown-2">
                                                        <div class="py-2"><a class="dropdown-item"
                                                                href="javascript:void(0);">Completed</a><a
                                                                class="dropdown-item"
                                                                href="javascript:void(0);">Processing</a><a
                                                                class="dropdown-item" href="javascript:void(0);">On
                                                                Hold</a><a class="dropdown-item"
                                                                href="javascript:void(0);">Pending</a>
                                                            <div class="dropdown-divider"></div><a
                                                                class="dropdown-item text-danger"
                                                                href="javascript:void(0);">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="btn-reveal-trigger">
                                            <td class="py-2">
                                                <a href="#">
                                                    <strong class="text-primary">#184</strong></a> by <strong
                                                    class="text-primary">Bucky
                                                    Robert</strong><br><a
                                                    href="https://fito.dexignzone.com/cdn-cgi/l/email-protection#305245535b49705548515d405c551e535f5d"><span
                                                        class="__cf_email__"
                                                        data-cfemail="462433252d3f06233e272b362a236825292b">[email&#160;protected]</span></a>
                                            </td>
                                            <td class="py-2">30/04/2020</td>
                                            <td class="py-2">Bucky Robert, 1 Infinite Loop, Cupertino, California 90210
                                                <p class="mb-0 text-500">Via Free Shipping</p>
                                            </td>
                                            <td class="py-2 text-end"><span
                                                    class="badge badge-warning badge-sm light">Pending<span
                                                        class="ms-1 fas fa-stream"></span></span>
                                            </td>
                                            <td class="py-2 text-end">$92
                                            </td>
                                            <td class="py-2 text-end">
                                                <div class="dropdown text-sans-serif"><button
                                                        class="btn btn-primary tp-btn-light sharp" type="button"
                                                        id="order-dropdown-3" data-bs-toggle="dropdown"
                                                        data-boundary="viewport" aria-haspopup="true"
                                                        aria-expanded="false"><span><svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                xmlns:xlink="http://www.w3.org/1999/xlink" width="18px"
                                                                height="18px" viewBox="0 0 24 24" version="1.1">
                                                                <g stroke="none" stroke-width="1" fill="none"
                                                                    fill-rule="evenodd">
                                                                    <rect x="0" y="0" width="24" height="24">
                                                                    </rect>
                                                                    <circle fill="#000000" cx="5" cy="12"
                                                                        r="2"></circle>
                                                                    <circle fill="#000000" cx="12" cy="12"
                                                                        r="2"></circle>
                                                                    <circle fill="#000000" cx="19" cy="12"
                                                                        r="2"></circle>
                                                                </g>
                                                            </svg></span></button>
                                                    <div class="dropdown-menu dropdown-menu-end border py-0"
                                                        aria-labelledby="order-dropdown-3">
                                                        <div class="py-2"><a class="dropdown-item"
                                                                href="javascript:void(0);">Completed</a><a
                                                                class="dropdown-item"
                                                                href="javascript:void(0);">Processing</a><a
                                                                class="dropdown-item" href="javascript:void(0);">On
                                                                Hold</a><a class="dropdown-item"
                                                                href="javascript:void(0);">Pending</a>
                                                            <div class="dropdown-divider"></div><a
                                                                class="dropdown-item text-danger"
                                                                href="javascript:void(0);">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
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
@endsection
