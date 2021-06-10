describe('Visual Regression Testing - https://qa-khutar.themeisle.com/nv/?blog_v2=yes', function () {
	const url = 'https://qa-khutar.themeisle.com/nv/?blog_v2=yes';
	it('Should not add any visual change', function () {
		cy.visit(url);
		cy.captureDocument();
	});
});
