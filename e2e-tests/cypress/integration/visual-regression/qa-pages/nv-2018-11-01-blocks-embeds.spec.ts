describe('Visual Regression Testing - https://qa-khutar.pearlfibers.com/nv/2018/11/01/blocks-embeds/', function () {
	const url = 'https://qa-khutar.pearlfibers.com/nv/2018/11/01/blocks-embeds/';
	it('Should not add any visual change', function () {
		cy.visit(url);
		cy.captureDocument();
	});
});
