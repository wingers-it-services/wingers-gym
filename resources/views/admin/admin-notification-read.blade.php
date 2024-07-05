@extends('admin.master')
@section('title','Dashboard')
@section('content')

<div class="content-body ">
                <div class="container-fluid">
        <div class="page-titles">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Email</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Read</a></li>
			</ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="email-left-box generic-width px-0 mb-5">
                            <div class="p-0">
                                <a href="/admin/admin-notification" class="btn btn-primary btn-block">Compose</a>
                            </div>
                            <div class="mail-list rounded mt-4">
                                <a href="/admin/admin-notification-inbox" class="list-group-item active"><i
                                        class="fa fa-inbox font-18 align-middle me-2"></i> Inbox <span
                                        class="badge badge-secondary  badge-sm float-end">198</span> </a>

                            </div>

                        </div>
                        <div class="email-right-box ms-0 ms-sm-4 ms-sm-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="right-box-padding">
                                        <div class="toolbar mb-4" role="toolbar">
											<div class="btn-group mb-1">
												<button type="button" class="btn btn-primary light px-3"><i class="fa fa-archive"></i></button>
												<button type="button" class="btn btn-primary light px-3"><i class="fa fa-exclamation-circle"></i></button>
												<button type="button" class="btn btn-primary light px-3"><i class="fa fa-trash"></i></button>
											</div>
											<div class="btn-group mb-1">
												<button type="button" class="btn btn-primary light dropdown-toggle px-3" data-bs-toggle="dropdown">
													<i class="fa fa-folder"></i> <b class="caret m-l-5"></b>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="javascript: void(0);">Social</a>
													<a class="dropdown-item" href="javascript: void(0);">Promotions</a>
													<a class="dropdown-item" href="javascript: void(0);">Updates</a>
													<a class="dropdown-item" href="javascript: void(0);">Forums</a>
												</div>
											</div>
											<div class="btn-group mb-1">
												<button type="button" class="btn btn-primary light dropdown-toggle px-3" data-bs-toggle="dropdown">
													<i class="fa fa-tag"></i> <b class="caret m-l-5"></b>
												</button>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="javascript: void(0);">Updates</a>
													<a class="dropdown-item" href="javascript: void(0);">Social</a>
													<a class="dropdown-item" href="javascript: void(0);">Promotions</a>
													<a class="dropdown-item" href="javascript: void(0);">Forums</a>
												</div>
											</div>
											<div class="btn-group mb-1">
												<button type="button" class="btn btn-primary light dropdown-toggle v" data-bs-toggle="dropdown">More <span class="caret m-l-5"></span>
												</button>
												<div class="dropdown-menu"> <a class="dropdown-item" href="javascript: void(0);">Mark as Unread</a> <a class="dropdown-item" href="javascript: void(0);">Add to Tasks</a>
													<a class="dropdown-item" href="javascript: void(0);">Add Star</a> <a class="dropdown-item" href="javascript: void(0);">Mute</a>
												</div>
											</div>
										</div>
                                        <div class="read-content">
                                            <div class="media pt-3">
												<img class="me-2 rounded" width="50" alt="image" src="https://fito.dexignzone.com/laravel/demo/images/avatar/1.jpg">
												<div class="media-body me-2">
													<h5 class="text-primary mb-0 mt-1">Ingredia Nutrisha</h5>
													<p class="mb-0">20 May 2018</p>
												</div>
												<a href="javascript:void(0)" class="btn btn-primary px-3 light"><i class="fa fa-reply"></i> </a>
												<a href="javascript:void(0)" class="btn btn-primary px-3 light ms-2"><i class="fa fa-long-arrow-right"></i> </a>
												<a href="javascript:void(0)" class="btn btn-primary px-3 light ms-2"><i class="fa fa-trash"></i></a>
											</div>
                                            <hr>
                                            <div class="media mb-2 mt-3">
                                                <div class="media-body"><span class="pull-right">07:23 AM</span>
                                                    <h5 class="my-1 text-primary">A collection of textile samples lay spread</h5>
                                                    <p class="read-content-email">
                                                        To: Me, <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="95fcfbf3fad5f0edf4f8e5f9f0bbf6faf8">[email&#160;protected]</a></p>
                                                </div>
                                            </div>
                                            <div class="read-content-body">
                                                <h5 class="mb-4">Hi,Ingredia,</h5>
                                                <p class="mb-2"><strong>Ingredia Nutrisha,</strong> A collection of textile samples lay spread out on the table - Samsa was a travelling salesman - and above it there hung a picture</p>
                                                <p class="mb-2">Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for
                                                    the far World of Grammar. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus.
                                                </p>
                                                <p class="mb-2">Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut
                                                    metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum
                                                    rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar,</p>
                                                <h5 class="pt-3">Kind Regards</h5>
                                                <p>Mr Smith</p>
                                                <hr>
                                            </div>
                                            <div class="read-content-attachment">
                                                <h6><i class="fa fa-download mb-2"></i> Attachments
                                                    <span>(3)</span></h6>
                                                <div class="row attachment">
                                                    <div class="col-auto">
                                                        <a href="javascript:void(0)" class="text-muted">My-Photo.png</a>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="javascript:void(0)" class="text-muted">My-File.docx</a>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="javascript:void(0)" class="text-muted">My-Resume.pdf</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group pt-3">
                                                <textarea name="write-email" id="write-email" cols="30" rows="5" class="form-control" placeholder="It's really an amazing.I want to know more about it..!"></textarea>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-primary " type="button">Send</button>
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




@endsection
