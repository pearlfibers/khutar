describe('Global Colors', function () {
	beforeEach(function () {
		cy.goToCustomizer();
		cy.getCustomizerControl('khutar_global_colors');
		cy.get('.khutar-global-colors-wrap').as('wrap');
	});

	it('Palette Selector', function () {
		cy.get('.khutar-global-color-palette-inner.active').should('contain', 'Base');

		cy.get('.khutar-global-color-palette-inner').contains('Dark Mode').click();

		cy.get('.khutar-global-color-palette-inner.active').should('contain', 'Dark Mode');
	});

	it('Palette Add and Delete', function () {
		cy.get('.add-palette-form').as('form');
		cy.get('@form').find('button').click();
		cy.get('@form').find('input').type('Base');
		cy.get('@form').find('button').contains('Add').should('be.disabled');
		cy.get('@form').find('input').clear();

		cy.get('@form').find('input').type('Test Palette');
		cy.get('@form').find('select').select('darkMode');
		cy.get('@form').find('button').contains('Add').click();

		cy.get('.khutar-global-color-palette-inner.active').should('contain', 'Test Palette');

		cy.get('.khutar-global-color-palette-inner.active')
			.siblings('.delete-palette')
			.click({ force: true });

		cy.get('.khutar-global-colors-confirm-delete-modal button')
			.contains('Delete')
			.click({ force: true });

		cy.get('.khutar-global-colors-confirm-delete-modal').should('not.exist');

		cy.get('.khutar-global-color-palette-inner.active').should('contain', 'Base');
	});

	it('Changes Colors', function () {
		cy.wait(500);
		cy.get('button.is-secondary');
		cy.get('.color-array-wrap .khutar-color-component').each((control) => {
			cy.get(control).find('button.is-secondary').click({ force: true });
			cy.get(control).find('input').clear().type('#000000');
			cy.get(control).find('.customize-control-title').click();
		});

		cy.get('.khutar-global-color-palette-inner.active .color').each((color) => {
			cy.get(color).should('have.css', 'background-color').and('eq', 'rgb(0, 0, 0)');
		});
		cy.get('#save').click({ force: true });
		cy.wait(500);
		cy.request('/wp-json/wpthememods/v1/settings').then((themeOptions) => {
			expect(themeOptions.body).to.contains(
				`{"base":{"name":"Base","allowDeletion":false,"colors":{"nv-primary-accent":"#000000","nv-secondary-accent":"#000000","nv-site-bg":"#000000","nv-light-bg":"#000000","nv-dark-bg":"#000000","nv-text-color":"#000000","nv-text-dark-bg":"#000000","nv-c-1":"#000000","nv-c-2":"#000000"}`,
			);
		});
	});

	it('Palette Selector in Color Component', function () {
		cy.getCustomizerControl('khutar_button_appearance').as('buttonControl');
		cy.wait(100);
		cy.get('@buttonControl').find('.global-color-picker').first().click();
		cy.get('.nv-custom-palette-wrap').should('be.visible');
		cy.get('.nv-custom-palette-wrap .nv-custom-palette-color').should('have.length', 9);

		cy.get('.nv-custom-palette-wrap .nv-custom-palette-color').first().click();

		cy.get('@buttonControl').find('.global-color-picker').first().should('have.class', 'active');

		cy.get('.nv-custom-palette-wrap button').contains('Edit').click();
	});

	it('Palette Reset', function () {
		cy.get('.reset-palette').should('not.be', 'disabled').click();
		cy.window().then((win) => {
			const controlValue = win.wp.customize.control('khutar_global_colors').setting.get();
			const nonBlack = Object.values(controlValue.palettes.base.colors).filter(
				(item) => item !== '#000000',
			);
			expect(nonBlack).to.have.length(9);
		});
	});
});
