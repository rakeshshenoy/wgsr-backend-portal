var NavBar = React.createClass({
    render: function(){
        return (
            <nav className="navbar navbar-default navbar-fixed-top">
                <div className="container">
                    <div className="navbar-header">
                        <a>
                            <img className="img-responsive navbar-brand img-rounded" id="hannahImg" src="images/hannah.png" alt="Hannah" />
                        </a>
                        <button type="button" className="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapseMenu">
                            <span className="icon-bar"></span>
                            <span className="icon-bar"></span>
                            <span className="icon-bar"></span>
                        </button>
                    </div>

                    <div className="collapse navbar-collapse" id="collapseMenu">
                        <ul className="nav navbar-nav" id="navbar-list">
                            <li><a href="home.html">Home</a></li>
                            <li><a href="availabledogs.php">Available Dogs</a></li>
                            <li><a href="donate.html">Donate</a></li>
                            <li><a href="">Application</a></li>
                            <li><a href="">Volunteer</a></li>
                            <li><a href="">Tails of Joy</a></li>
                            <li><a href="">F.A.Q.</a></li>
                            <li><a href="">Adopted Dogs</a></li>
                            <li><a href="">Shop</a></li>
                            
            
                        </ul>
                    </div>
                </div>
            </nav>
        );
    }
});

var Banner = React.createClass({
  render: function() {
    return (
      <div className="banner row" id="bannerImg">
        <img className="img-responsive col-xs-12" id="bannerImg" src="images/banner71.png" alt="Westside German Shepherd Rescue of Los Angeles" />
      </div>
    );
  }
});

ReactDOM.render(<div className="container">
                    <NavBar />
                    <Banner />
                </div>,
            document.getElementById('navbarAndBanner')
);