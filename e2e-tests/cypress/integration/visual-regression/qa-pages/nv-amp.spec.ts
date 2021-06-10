describe('Visual Regression Testing - https://qa-khutar.pearlfibers.com/nv/?amp', function () {
	const url = 'https://qa-khutar.pearlfibers.com/nv/?amp';
	it('Should not add any visual change', function () {
		cy.visit(url);
		cy.captureDocument();
	});
});
