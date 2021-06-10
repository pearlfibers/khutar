describe('Visual Regression Testing - https://qa-khutar.pearlfibers.com/nv/product/apple-peppermint-smoothie/?d=rtl', function () {
	const url = 'https://qa-khutar.pearlfibers.com/nv/product/apple-peppermint-smoothie/?d=rtl';
	it('Should not add any visual change', function () {
		cy.visit(url);
		cy.captureDocument();
	});
});
