describe('Visual Regression Testing - https://qa-khutar.pearlfibers.com/nv/df480-shop/', function () {
	const url = 'https://qa-khutar.pearlfibers.com/nv/df480-shop/';
	it('Should not add any visual change', function () {
		cy.visit(url);
		cy.captureDocument();
	});
});
