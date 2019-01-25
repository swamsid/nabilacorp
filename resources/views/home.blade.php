@extends('main')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<div>
    <!-- <div id="loading"></div> -->
        <!--BEGIN BACK TO TOP-->
        <a id="totop" href="#"><i class="fa fa-angle-up"></i></a>
        <!--END BACK TO TOP-->
            <!--BEGIN PAGE WRAPPER-->
            <div id="page-wrapper">
                <!--BEGIN TITLE & BREADCRUMB PAGE-->
                <div id="title-breadcrumb-option-demo" class="page-title-breadcrumb">
                    <div class="page-header pull-left">
                        <div class="page-title">
                            Home</div>
                    </div>
                    <ol class="breadcrumb page-breadcrumb pull-right">
                        <li><i class="fa fa-home"></i>&nbsp;<a href="{{ url('/home') }}">Home</a></li>
                    </ol>
                    <div class="clearfix">
                    </div>
                </div>
                <!--END TITLE & BREADCRUMB PAGE-->
                <!--BEGIN CONTENT-->
                <div class="page-content">
                    <div id="tab-general">
                        <div id="sum_box" class="row mbl">
                            <div class="col-sm-6 col-md-3">
                               
                            </div>
                            <div class="col-sm-6 col-md-3">
                            
                            </div>
                            <div class="col-sm-6 col-md-3">
                                
                            </div>
                            <div class="col-sm-6 col-md-3">
                                
                            </div>
                        </div>
                        <div class="row mbl">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <div class="portlet box">
                                    <div class="portlet-header">
                                        <div class="caption">
                                            Button
                                        </div>
                                        <div>
            <select style="width:300px" id="source">
               <optgroup label="Alaskan/Hawaiian Time Zone">
                   <option value="AK">Alaska</option>
                   <option value="HI">Hawaii</option>
               </optgroup>
               <optgroup label="Pacific Time Zone">
                   <option value="CA">California</option>
                   <option value="NV">Nevada</option>
                   <option value="OR">Oregon</option>
                   <option value="WA">Washington</option>
               </optgroup>
               <optgroup label="Mountain Time Zone">
                   <option value="AZ">Arizona</option>
                   <option value="CO">Colorado</option>
                   <option value="ID">Idaho</option>
                   <option value="MT">Montana</option><option value="NE">Nebraska</option>
                   <option value="NM">New Mexico</option>
                   <option value="ND">North Dakota</option>
                   <option value="UT">Utah</option>
                   <option value="WY">Wyoming</option>
               </optgroup>
               <optgroup label="Central Time Zone">
                   <option value="AL">Alabama</option>
                   <option value="AR">Arkansas</option>
                   <option value="IL">Illinois</option>
                   <option value="IA">Iowa</option>
                   <option value="KS">Kansas</option>
                   <option value="KY">Kentucky</option>
                   <option value="LA">Louisiana</option>
                   <option value="MN">Minnesota</option>
                   <option value="MS">Mississippi</option>
                   <option value="MO">Missouri</option>
                   <option value="OK">Oklahoma</option>
                   <option value="SD">South Dakota</option>
                   <option value="TX">Texas</option>
                   <option value="TN">Tennessee</option>
                   <option value="WI">Wisconsin</option>
               </optgroup>
               <optgroup label="Eastern Time Zone">
                   <option value="CT">Connecticut</option>
                   <option value="DE">Delaware</option>
                   <option value="FL">Florida</option>
                   <option value="GA">Georgia</option>
                   <option value="IN">Indiana</option>
                   <option value="ME">Maine</option>
                   <option value="MD">Maryland</option>
                   <option value="MA">Massachusetts</option>
                   <option value="MI">Michigan</option>
                   <option value="NH">New Hampshire</option><option value="NJ">New Jersey</option>
                   <option value="NY">New York</option>
                   <option value="NC">North Carolina</option>
                   <option value="OH">Ohio</option>
                   <option value="PA">Pennsylvania</option><option value="RI">Rhode Island</option><option value="SC">South Carolina</option>
                   <option value="VT">Vermont</option><option value="VA">Virginia</option>
                   <option value="WV">West Virginia</option>
               </optgroup>
              </select>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <button class="btn btn-primary">Primary</button>
                                        <button class="btn btn-success">Success</button>
                                        <button class="btn btn-info">Info</button>
                                        <button class="btn btn-warning">Warning</button>
                                        <button class="btn btn-danger">Danger</button>
                                        <button class="btn btn-default">Default</button>
                                        <button class="btn btn-primary btn-outlined">Primary</button>
                                        <button class="btn btn-success btn-outlined">Success</button>
                                        <button class="btn btn-info btn-outlined">Info</button>
                                        <button class="btn btn-warning btn-outlined">Warning</button>
                                        <button class="btn btn-danger btn-outlined">Danger</button>
                                        <button class="btn btn-default btn-outlined">Default</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mbl">
                            <div class="col-lg-8">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h4 class="mbs">
                                                    Network Performance</h4>
                                                <p class="help-block">
                                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem...</p>
                                                <div id="area-chart-spline" style="width: 100%; height: 300px">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <h4 class="mbm">
                                                    Server Status</h4>
                                                <span class="task-item">CPU Usage (25 - 32 cpus)<small class="pull-right text-muted">40%</small><div
                                                    class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 40%;" class="progress-bar progress-bar-orange">
                                                        <span class="sr-only">40% Complete (success)</span></div>
                                                </div>
                                                </span><span>Memory Usage (2.5GB)<small class="pull-right text-muted">60%</small><div
                                                    class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 60%;" class="progress-bar progress-bar-blue">
                                                        <span class="sr-only">60% Complete (success)</span></div>
                                                </div>
                                                </span><span>Disk Usage (C:\ 120GB , D:\ 430GB)<small class="pull-right text-muted">55%</small><div
                                                    class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="55" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 55%;" class="progress-bar progress-bar-green">
                                                        <span class="sr-only">55% Complete (success)</span></div>
                                                </div>
                                                </span><span>Domain (2/5)<small class="pull-right text-muted">66%</small><div class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="66" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 66%;" class="progress-bar progress-bar-yellow">
                                                        <span class="sr-only">66% Complete (success)</span></div>
                                                </div>
                                                </span><span>Database (90/100)<small class="pull-right text-muted">90%</small><div
                                                    class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 90%;" class="progress-bar progress-bar-pink">
                                                        <span class="sr-only">90% Complete (success)</span></div>
                                                </div>
                                                </span><span>Email Account (25/50)<small class="pull-right text-muted">50%</small><div
                                                    class="progress progress-sm">
                                                    <div role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                                        style="width: 50%;" class="progress-bar progress-bar-violet">
                                                        <span class="sr-only">50% Complete (success)</span></div>
                                                </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="portlet box">
                                    <div class="portlet-header">
                                        <div class="caption">
                                            Chats</div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="chat-scroller">
                                            <ul class="chats">
                                                <li class="in">
                                                    <img src="{{asset('assets/images/avatar/48.jpg')}}" class="avatar img-responsive" />
                                                    <div class="message">
                                                        <span class="chat-arrow"></span><a href="#" class="chat-name">Admin</a>&nbsp;<span
                                                            class="chat-datetime">at July 06, 2014 17:06</span><span class="chat-body">Lorem ipsum
                                                                dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt
                                                                ut laoreet dolore magna aliquam erat volutpat.</span></div>
                                                </li>
                                                <li class="out">
                                                    <img src="{{asset('assets/images/avatar/48.jpg')}}" class="avatar img-responsive" />
                                                    <div class="message">
                                                        <span class="chat-arrow"></span><a href="#" class="chat-name">Admin</a>&nbsp;<span
                                                            class="chat-datetime">at July 06, 2014 18:06</span><span class="chat-body">Lorem ipsum
                                                                dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt
                                                                ut laoreet dolore magna aliquam erat volutpat.</span></div>
                                                </li>
                                                <li class="in">
                                                    <img src="{{asset('assets/images/avatar/48.jpg')}}" class="avatar img-responsive" />
                                                    <div class="message">
                                                        <span class="chat-arrow"></span><a href="#" class="chat-name">Admin</a>&nbsp;<span
                                                            class="chat-datetime">at July 06, 2014 17:06</span><span class="chat-body">Lorem ipsum
                                                                dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt
                                                                ut laoreet dolore magna aliquam erat volutpat.</span></div>
                                                </li>
                                                <li class="out">
                                                    <img src="{{asset('assets/images/avatar/48.jpg')}}" class="avatar img-responsive" />
                                                    <div class="message">
                                                        <span class="chat-arrow"></span><a href="#" class="chat-name">Admin</a>&nbsp;<span
                                                            class="chat-datetime">at July 06, 2014 18:06</span><span class="chat-body">Lorem ipsum
                                                                dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt
                                                                ut laoreet dolore magna aliquam erat volutpat.</span></div>
                                                </li>
                                                <li class="in">
                                                    <img src="{{asset('assets/images/avatar/48.jpg')}}" class="avatar img-responsive" />
                                                    <div class="message">
                                                        <span class="chat-arrow"></span><a href="#" class="chat-name">Admin</a>&nbsp;<span
                                                            class="chat-datetime">at July 06, 2014 17:06</span><span class="chat-body">Lorem ipsum
                                                                dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt
                                                                ut laoreet dolore magna aliquam erat volutpat.</span></div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="chat-form">
                                            <div class="input-group">
                                                <input id="input-chat" type="text" placeholder="Type a message here..." class="form-control" /><span
                                                    id="btn-chat" class="input-group-btn">
                                                    <button type="button" class="btn btn-green">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mbl">
                            <div class="col-lg-4">
                                <div class="panel">
                                    <div class="panel-body">
                                        <div class="profile">
                                            <div style="margin-bottom: 15px" class="row">
                                                <div class="col-xs-12 col-sm-8">
                                                    <h2>
                                                        John Doe</h2>
                                                    <p>
                                                        <strong>About:</strong> Web Designer / UI.</p>
                                                    <p>
                                                        <strong>Hobbies:</strong> Read, out with friends, listen to music, draw and learn
                                                        new things.</p>
                                                    <p>
                                                        <strong class="mrs">Skills:</strong><span class="label label-green mrs">html5</span><span
                                                            class="label label-green mrs">css3</span><span class="label label-green mrs">jquery</span></p>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 text-center">
                                                    <figure><img src="../assets/images/avatar/128.jpg" alt="" style="display: inline-block" class="img-responsive img-circle"/>
                                                    <figcaption class="ratings"><p><a href="#"><span class="fa fa-star"></span></a><a href="#"><span class="fa fa-star"></span></a><a href="#"><span class="fa fa-star"></span></a><a href="#"><span class="fa fa-star"></span></a><a href="#"><span class="fa fa-star-o"></span></a></p></figcaption>
                                                </figure>
                                                </div>
                                            </div>
                                            <div class="row text-center divider">
                                                <div class="col-xs-12 col-sm-4 emphasis">
                                                    <h2>
                                                        <strong>20,7K</strong></h2>
                                                    <p>
                                                        <small>Followers</small>
                                                    </p>
                                                    <button class="btn btn-yellow btn-block">
                                                        <span class="fa fa-plus-circle"></span>&nbsp; Follow
                                                    </button>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 emphasis">
                                                    <h2>
                                                        <strong>245</strong></h2>
                                                    <p>
                                                        <small>Following</small>
                                                    </p>
                                                    <button class="btn btn-blue btn-block">
                                                        <span class="fa fa-user"></span>&nbsp; Profile
                                                    </button>
                                                </div>
                                                <div class="col-xs-12 col-sm-4 emphasis">
                                                    <h2>
                                                        <strong>43</strong></h2>
                                                    <p>
                                                        <small>Snippets</small>
                                                    </p>
                                                    <div class="btn-group dropup">
                                                        <button type="button" data-toggle="dropdown" class="btn btn-orange dropdown-toggle">
                                                            <span class="fa fa-gear"></span>&nbsp; Options
                                                        </button>
                                                        <ul role="menu" class="dropdown-menu pull-right text-left">
                                                            <li><a href="#"><span class="fa fa-envelope"></span>&nbsp; Send an email</a></li>
                                                            <li><a href="#"><span class="fa fa-list"></span>&nbsp; Add or remove from a list</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="#"><span class="fa fa-warning"></span>&nbsp; Report this user for spam</a></li>
                                                            <li class="divider"></li>
                                                            <li><a href="#" role="button" class="btn disabled">Unfollow</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="portlet box">
                                    <div class="portlet-header">
                                        <div class="caption">
                                            Todo List</div>
                                    </div>
                                    <div style="overflow: hidden;" class="portlet-body">
                                        <ul class="todo-list sortable">
                                            <li class="clearfix"><span class="drag-drop"><i></i></span>
                                                <div class="todo-check pull-left">
                                                    <input type="checkbox" value="" /></div>
                                                <div class="todo-title">
                                                    Sed ut perspiciatis unde omnis iste</div>
                                                <div class="todo-actions pull-right clearfix">
                                                    <a href="#" class="todo-complete"><i class="fa fa-check"></i></a><a href="#" class="todo-edit">
                                                        <i class="fa fa-edit"></i></a><a href="#" class="todo-remove"><i class="fa fa-trash-o">
                                                        </i></a>
                                                </div>
                                            </li>
                                            <li class="clearfix"><span class="drag-drop"><i></i></span>
                                                <div class="todo-check pull-left">
                                                    <input type="checkbox" value="" /></div>
                                                <div class="todo-title">
                                                    At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium</div>
                                                <div class="todo-actions pull-right clearfix">
                                                    <a href="#" class="todo-complete"><i class="fa fa-check"></i></a><a href="#" class="todo-edit">
                                                        <i class="fa fa-edit"></i></a><a href="#" class="todo-remove"><i class="fa fa-trash-o">
                                                        </i></a>
                                                </div>
                                            </li>
                                            <li class="clearfix"><span class="drag-drop"><i></i></span>
                                                <div class="todo-check pull-left">
                                                    <input type="checkbox" value="" /></div>
                                                <div class="todo-title">
                                                    Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo
                                                    minus id</div>
                                                <div class="todo-actions pull-right clearfix">
                                                    <a href="#" class="todo-complete"><i class="fa fa-check"></i></a><a href="#" class="todo-edit">
                                                        <i class="fa fa-edit"></i></a><a href="#" class="todo-remove"><i class="fa fa-trash-o">
                                                        </i></a>
                                                </div>
                                            </li>
                                            <li class="clearfix"><span class="drag-drop"><i></i></span>
                                                <div class="todo-check pull-left">
                                                    <input type="checkbox" value="" /></div>
                                                <div class="todo-title">
                                                    Et harum quidem rerum facilis est</div>
                                                <div class="todo-actions pull-right clearfix">
                                                    <a href="#" class="todo-complete"><i class="fa fa-check"></i></a><a href="#" class="todo-edit">
                                                        <i class="fa fa-edit"></i></a><a href="#" class="todo-remove"><i class="fa fa-trash-o">
                                                        </i></a>
                                                </div>
                                            </li>
                                            <li class="clearfix"><span class="drag-drop"><i></i></span>
                                                <div class="todo-check pull-left">
                                                    <input type="checkbox" value="" /></div>
                                                <div class="todo-title">
                                                    Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet</div>
                                                <div class="todo-actions pull-right clearfix">
                                                    <a href="#" class="todo-complete"><i class="fa fa-check"></i></a><a href="#" class="todo-edit">
                                                        <i class="fa fa-edit"></i></a><a href="#" class="todo-remove"><i class="fa fa-trash-o">
                                                        </i></a>
                                                </div>
                                            </li>
                                            <li class="clearfix"><span class="drag-drop"><i></i></span>
                                                <div class="todo-check pull-left">
                                                    <input type="checkbox" value="" /></div>
                                                <div class="todo-title">
                                                    Excepteur sint occaecat cupidatat non proident</div>
                                                <div class="todo-actions pull-right clearfix">
                                                    <a href="#" class="todo-complete"><i class="fa fa-check"></i></a><a href="#" class="todo-edit">
                                                        <i class="fa fa-edit"></i></a><a href="#" class="todo-remove"><i class="fa fa-trash-o">
                                                        </i></a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                    </div>
                </div>
                <!--END CONTENT-->
                <!--BEGIN FOOTER-->
                <div id="footer">
                    <div class="copyright">
                        <a href="#">{{date('Y')}} © TammaFood</a></div>
                </div>
                <!--END FOOTER-->
            </div>
            <!--END PAGE WRAPPER-->
        </div>
    </div>
                
</div>
</body>
</html>

@endsection

 