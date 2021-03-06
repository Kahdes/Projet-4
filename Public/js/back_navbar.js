var Navbar = {
	url: location.href,
	linkElts: null,
	dashboardElt: null,
	createElt: null,
	dashboardRegex: /index\.php\?action=dashboard/,
	dashboardPageRegex: /(&page_comm=([\d]){1,}){1}/,
	createRegex: /admin=create$/,

	init() {
		this.linkElts = document.getElementsByClassName('navbar-link');
		this.dashboardElt = document.getElementById('dashboard');
		this.createElt = document.getElementById('create');
	},

	activeLink() {
		if (this.dashboardRegex.test(this.url)) {
			if (this.dashboardPageRegex.test(this.url)) {
				this.dashboardElt.setAttribute("class", "active");
			} else if (this.createRegex.test(this.url)) {
				this.createElt.setAttribute("class", "active");
			} else {
				this.dashboardElt.setAttribute("class", "active");
			}			
		} 
	}
};

Navbar.init();
Navbar.activeLink();