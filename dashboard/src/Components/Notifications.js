/* global khutarDash */
import Notification from './Notification';

const Notifications = () => {
	if (!khutarDash.notifications) {
		return null;
	}
	if (1 > khutarDash.notifications.length) {
		return null;
	}

	return (
		<div className="notifications">
			{Object.keys(khutarDash.notifications).map((slug, index) => {
				return (
					<Notification
						key={index}
						data={khutarDash.notifications[slug]}
						slug={slug}
					/>
				);
			})}
		</div>
	);
};

export default Notifications;
