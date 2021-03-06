describe('Ordering Control', function () {
	let value = null;

	beforeEach(function () {
		cy.goToCustomizer();
		cy.window().then((win) => {
			win.wp.customize.control('khutar_post_content_ordering').focus();
			value = JSON.parse(win.wp.customize.control('khutar_post_content_ordering').setting());
			cy.get('#customize-control-khutar_blog_ordering_content_heading').click();
		});

		cy.get('#customize-control-khutar_post_content_ordering').as('control');
	});

	before(function () {
		cy.goToCustomizer();
		cy.window().then((win) => {
			const defaultValue = JSON.stringify(['thumbnail', 'title-meta', 'excerpt']);
			const currentValue = win.wp.customize.control('khutar_post_content_ordering').setting();
			if (currentValue !== defaultValue) {
				win.wp.customize.control('khutar_post_content_ordering').setting.set(defaultValue);
				cy.aliasRestRoutes();
				cy.get('#save').click();
				cy.wait('@customizerSave').then((interception) => {
					expect(interception.response.body.success).to.be.true;
					expect(interception.response.statusCode).to.equal(200);
					cy.wait(2000);
				});
			}
		});
	});

	it('Test Ordering', function () {
		cy.get('@control').find('.handle').should('have.length', 3);
		dropElAfter(
			'#customize-control-khutar_post_content_ordering .items-list .khutar-sortable-item .handle',
			0,
			1,
		);
		cy.window().then((win) => {
			const newValue = JSON.parse(win.wp.customize.control('khutar_post_content_ordering').setting());
			const tmp = value[0];
			value[0] = value[1];
			value[1] = value[2];
			value[2] = tmp;
			expect(value).to.deep.eq(newValue);
		});
	});

	it('Test Hiding', function () {
		cy.get('@control').find('.toggle').should('have.length', 3);
		cy.get('@control').find('.toggle').first().click();
		cy.get('@control').find('.khutar-sortable-item.disabled').should('exist');
		cy.window().then((win) => {
			const newValue = JSON.parse(win.wp.customize.control('khutar_post_content_ordering').setting());
			value.shift();
			expect(value).to.deep.eq(newValue);
		});
	});
});

/**
 * Drag and drop an element after another.
 *
 * @param selector
 * @param moveFrom
 * @param moveTo
 * @example cy.dropElAfter('control', 0, 1)
 */
const dropElAfter = (selector, moveFrom: number, moveTo: number) => {
	cy.get(selector).then((el) => {
		const drag = el[moveFrom].getBoundingClientRect();
		const drop = el[moveTo].getBoundingClientRect();
		cy.get(el[moveFrom]).trigger('mousedown', {
			which: 1,
			pageX: drag.x,
			pageY: drag.y,
		});
		cy.document().trigger('mousemove', {
			which: 1,
			pageX: drop.x,
			pageY: drop.y + 35,
		});
		cy.wait(200);
		cy.document().trigger('mouseup');
	});
};
