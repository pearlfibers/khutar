describe('Visual Regression Testing - https://qa-khutar.pearlfibers.com/nv/product/ship-your-idea-2/', function () {
	const url = 'https://qa-khutar.pearlfibers.com/nv/product/ship-your-idea-2/';
	it('Should not add any visual change', function () {
		cy.visit(url);
		cy.captureDocument();
	});
});
