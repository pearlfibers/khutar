import { ToggleControl } from '@wordpress/components';

const Toggle = ({ description, label, checked, onChange }) => {
	return (
		<div className="khutar-white-background-control">
			<ToggleControl
				className="khutar-toggle-control"
				checked={checked}
				label={label}
				onChange={onChange}
			/>
			{description && (
				<span
					className="customize-control-description"
					dangerouslySetInnerHTML={{
						__html: description,
					}}
				/>
			)}
		</div>
	);
};

export default Toggle;
