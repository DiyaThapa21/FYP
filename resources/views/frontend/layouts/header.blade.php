<header class="header shop">
   
    <div class="topbar">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12">
                 
                    <div class="top-left">
                        <ul class="list-main">
                            
                            <li><i class="ti-headphone-alt"></i> +977-9800000000</li>
                            <li><i class="ti-email"></i> test@gmail.com</li>
                        </ul>
                    </div>
                    
                </div>
                <div class="col-lg-6 col-md-12 col-12">
                  
                    <div class="right-content">
                        <ul class="list-main">
                            
                            @auth 
                                @if(Auth::user()->role=='admin')
                                    <li><i class="ti-user"></i> <a href="{{route('dashboard')}}" >Dashboard</a></li>
                                @else 
                                    <li><i class="ti-user"></i> <a href="{{route('dashboard')}}" >Dashboard</a></li>
                                @endif
                                <li><i class="ti-power-off"></i> <a href="{{route('user.logout')}}">Logout</a></li>

                            @else
                                <li><i class="ti-power-off"></i><a href="{{route('login.form')}}">Login /</a> <a href="{{route('register.form')}}">Register</a></li>
                            @endauth
                        </ul>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
   
    <div class="middle-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-12">
                 
                    <div class="logo">
                       
                    </div>
                    
                    <div class="search-top">
                        <div class="top-search"><a href="#0"><i class="ti-search"></i></a></div>
                     
                        <div class="search-top">
                            <form class="search-form">
                                <input type="text" placeholder="Search here..." name="search">
                                <button value="search" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                      
                    </div>
                   
                    <div class="mobile-nav"></div>
                </div>
                <div class="col-lg-8 col-md-7 col-12">
                    <div class="search-bar-top">
                        <div class="search-bar">
                            <select>
                                <option >All Category</option>
                               
                            </select>
                            <form method="POST" action="">
                               
                                <input name="search" placeholder="Search products name, brand here....." type="search">
                                <button class="btnn" type="submit"><i class="ti-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-12">
                    <div class="right-bar">
                        
                        <div class="sinlge-bar shopping">
                           
                          
                            <a href="" class="single-icon"><i class="fa fa-heart-o"></i> <span class="total-count">0</span></a>
                          
                           
                        </div>
                       
                        <div class="sinlge-bar shopping">
                            
                            <a href="" class="single-icon"><i class="ti-bag"></i> <span class="total-count">0</span></a>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="header-inner">
        <div class="container">
            <div class="cat-nav-head">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="menu-area">
                            <nav class="navbar navbar-expand-lg">
                                <div class="navbar-collapse">	
                                    <div class="nav-inner">	
                                        <ul class="nav main-menu menu navbar-nav">
                                            <li class="{{Request::path()=='home' ? 'active' : ''}}"><a href="{{route('home')}}">Home</a></li>
                                            <li class="{{Request::path()=='about-us' ? 'active' : ''}}"><a href="{{route('about-us')}}">About Us</a></li>
                                            <li class="@if(Request::path()=='product-grids'||Request::path()=='product-lists')  active  @endif"><a href="">Products</a></li>												
                                               
                                            <li class="{{Request::path()=='blog' ? 'active' : ''}}"><a href="">Blog</a></li>									
                                               
                                            <li class="{{Request::path()=='contact' ? 'active' : ''}}"><a href="{{route('contact')}}">Contact Us</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</header>