describe('Visual Regression Testing - https://qa-khutar.pearlfibers.com/nv/2018/11/03/block-button/', function () {
	const url = 'https://qa-khutar.pearlfibers.com/nv/2018/11/03/block-button/';
	it('Should not add any visual change', function () {
		cy.visit(url);
		cy.captureDocument();
	});
});
