import { __ } from '@wordpress/i18n';
import { Button } from '@wordpress/components';
import classnames from 'classnames';
import { globalPaletteColors } from '../common/common';

const CustomPalette = ({ title, onChange, activeColor }) => {
	const focusGlobalColors = () => {
		wp.customize.control('khutar_global_colors').focus();
	};

	return (
		<div className="nv-custom-palette-wrap">
			<div className="header">
				{title && (
					<span className="customize-control-title">{title}</span>
				)}
				<Button isLink onClick={focusGlobalColors}>
					{__('Edit', 'khutar')}
				</Button>
			</div>
			<div className="nv-custom-palette-inner">
				{globalPaletteColors.map((group, index) => {
					return (
						<ul key={index}>
							{Object.keys(group).map((slug) => {
								const style = {
									backgroundColor: `var(--${slug})`,
								};
								const buttonClasses = classnames([
									'nv-custom-palette-color',
									{
										active:
											activeColor === `var(--${slug})`,
									},
								]);

								return (
									<li title={group[slug]} key={slug}>
										<a
											href="#global-select"
											onClick={(e) => {
												e.preventDefault();
												onChange(`var(--${slug})`);
											}}
										>
											<span
												style={style}
												className={buttonClasses}
											/>
											<span>{group[slug]}</span>
										</a>
									</li>
								);
							})}
						</ul>
					);
				})}
			</div>
		</div>
	);
};

export default CustomPalette;
