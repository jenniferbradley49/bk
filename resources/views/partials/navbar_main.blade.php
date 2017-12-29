         <div class="bs-component">
              <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                  <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2">
                      <span class="sr-only">Toggle navigation</span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                      <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">{{ env('BRAND') }}</a>
                  </div>

                  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-2">
                    <ul class="nav navbar-nav">
                    <!-- 
                      <li class="active"><a href="/">Link <span class="sr-only">(current)</span></a></li>
                   -->
                      <li><a href="/">Home</a></li>
                      <li><a href="/contact">Contact</a></li>
                      <li class="dropdown">
                        <a href="/products" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Laravel software products<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="/three_step_security">Three Step Security</a></li>
<!--
                          <li><a href="#">Another action</a></li>
                          <li><a href="#">Something else here</a></li>
                          <li class="divider"></li>
                          <li><a href="#">Separated link</a></li>
                          <li class="divider"></li>
                          <li><a href="#">One more separated link</a></li>
 -->                         
                        </ul>
                      </li>
                    
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Coming soon<span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="/two_way_auth">Two way (host) authentication</a></li>

                          <li><a href="#">Configurable automatic logout - time limitation for inactivity</a></li>
                          <li><a href="#">Require telephone call to log in</a></li>
                          <li><a href="#">Restrict log in to specific IP address</a></li>
                          <li><a href="#">Require telephone call to log in</a></li>
                          <li><a href="#">Require public / private key to log in</a></li>
                          <li><a href="#">Require roles</a></li>
                          <li><a href="#">Limit to use by a single login per user</a></li>
                          <li><a href="#">Manipulate / control multiple logins per user</a></li>
                          <!-- 
                          <li class="divider"></li>
                          <li><a href="#">Separated link</a></li>
                          <li class="divider"></li>
                          <li><a href="#">One more separated link</a></li>
 -->                         
                        </ul>
                      </li>
                      <li><a href="/purchase">Purchase</a></li>
                      
                    </ul>
                    
  <!--                   
                    <form class="navbar-form navbar-left" role="search">
                      <div class="form-group">
                        <input type="text" class="form-control" placeholder="Search">
                      </div>
                      <button type="submit" class="btn btn-default">Submit</button>
                    </form>
      -->
     <!-- 
                    <ul class="nav navbar-nav navbar-right">
                      <li><a href="/sign_up">Get an account</a></li>
                      <li><a href="/client/dashboard">Client area</a></li>
                      <li><a href="/admin/dashboard">Admin login</a></li>
                    </ul>
   --> 
   {{ $navbar_right }}                                  </div>
                </div>
              </nav>
            </div><!-- /example -->

<!-- 
<div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a href="../" class="navbar-brand">Bootswatch</a>
          <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
   
   
   
        <div class="navbar-collapse collapse" id="navbar-main">
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Themes <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="themes">
                <li><a href="../default/">Default</a></li>
                <li class="divider"></li>
                <li><a href="../cerulean/">Cerulean</a></li>
                <li><a href="../cosmo/">Cosmo</a></li>
                <li><a href="../cyborg/">Cyborg</a></li>
                <li><a href="../darkly/">Darkly</a></li>
                <li><a href="../flatly/">Flatly</a></li>
                <li><a href="../journal/">Journal</a></li>
                <li><a href="../lumen/">Lumen</a></li>
                <li><a href="../paper/">Paper</a></li>
                <li><a href="../readable/">Readable</a></li>
                <li><a href="../sandstone/">Sandstone</a></li>
                <li><a href="../simplex/">Simplex</a></li>
                <li><a href="../slate/">Slate</a></li>
                <li><a href="../spacelab/">Spacelab</a></li>
                <li><a href="../superhero/">Superhero</a></li>
                <li><a href="../united/">United</a></li>
                <li><a href="../yeti/">Yeti</a></li>
              </ul>
            </li>
            <li>
              <a href="../help/">Help</a>
            </li>
            <li>
              <a href="http://news.bootswatch.com">Blog</a>
            </li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="download">Sandstone <span class="caret"></span></a>
              <ul class="dropdown-menu" aria-labelledby="download">
                <li><a href="http://jsfiddle.net/bootswatch/m0nv7a0o/">Open Sandbox</a></li>
                <li class="divider"></li>
                <li><a href="./bootstrap.min.css">bootstrap.min.css</a></li>
                <li><a href="./bootstrap.css">bootstrap.css</a></li>
                <li class="divider"></li>
                <li><a href="./variables.less">variables.less</a></li>
                <li><a href="./bootswatch.less">bootswatch.less</a></li>
                <li class="divider"></li>
                <li><a href="./_variables.scss">_variables.scss</a></li>
                <li><a href="./_bootswatch.scss">_bootswatch.scss</a></li>
              </ul>
            </li>
          </ul>

          <ul class="nav navbar-nav navbar-right">
            <li><a href="http://builtwithbootstrap.com/" target="_blank">Built With Bootstrap</a></li>
            <li><a href="https://wrapbootstrap.com/?ref=bsw" target="_blank">WrapBootstrap</a></li>
          </ul>

        </div>
      </div>
    </div>
 -->
