describe('Visual Regression Testing - https://qa-khutar.pearlfibers.com/nv/2018/11/02/column-blocks/', function () {
	const url = 'https://qa-khutar.pearlfibers.com/nv/2018/11/02/column-blocks/';
	it('Should not add any visual change', function () {
		cy.visit(url);
		cy.captureDocument();
	});
});
