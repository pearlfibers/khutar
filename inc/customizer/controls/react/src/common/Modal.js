import PropTypes from 'prop-types';

const { Modal } = wp.components;
const { useState, useEffect } = wp.element;
const khutarModal = ({ children, opened, trigger, openAttr, title }) => {
	const [open, setOpen] = useState(false);
	useEffect(() => {
		if (!openAttr) return false;
		global.addEventListener('DOMContentLoaded', () => {
			const outsideTrigger = document.querySelectorAll(
				`[data-open-nv-modal=${openAttr}]`
			);
			if (!outsideTrigger) return false;
			outsideTrigger.forEach((item) => {
				item.addEventListener('click', (e) => {
					e.preventDefault();
					setOpen(true);
				});
			});
		});
	}, []);

	const dismiss = () => {
		setOpen(false);
	};

	if (!open && !opened) {
		return null;
	}

	return (
		<>
			{trigger}
			<Modal
				className="khutar-ui-modal-wrap"
				title={title}
				onRequestClose={dismiss}
				shouldCloseOnClickOutside
				isDismissible
			>
				{children}
			</Modal>
		</>
	);
};

khutarModal.propTypes = {
	children: PropTypes.element.isRequired,
	opened: PropTypes.bool,
	trigger: PropTypes.element,
	openAttr: PropTypes.string,
	title: PropTypes.string,
};

export default khutarModal;
