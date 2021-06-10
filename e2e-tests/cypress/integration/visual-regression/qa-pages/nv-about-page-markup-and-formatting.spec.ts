describe('Visual Regression Testing - https://qa-khutar.pearlfibers.com/nv/about/page-markup-and-formatting/', function () {
	const url = 'https://qa-khutar.pearlfibers.com/nv/about/page-markup-and-formatting/';
	it('Should not add any visual change', function () {
		cy.visit(url);
		cy.captureDocument();
	});
});
