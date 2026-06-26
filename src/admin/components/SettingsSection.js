import { ToggleControl, TextControl } from '@wordpress/components';

export default function SettingsSection({ section, settings, onToggle }) {
	return (
		<div style={styles.card}>
			<p style={styles.desc}>
				Configure settings for <strong>{section.title}</strong>.
			</p>

			<div style={styles.fields}>
				{section.fields.map((field) => (
					<div key={field.id} style={styles.fieldRow}>
						{field.type === 'toggle' ? (
							<ToggleControl
								label={field.label}
								checked={settings[field.id] === true}
								onChange={(val) => onToggle(field.id, val)}
								__nextHasNoMarginBottom
							/>
						) : field.type === 'text' ? (
							<div style={styles.textField}>
								<label style={styles.textLabel}>{field.label}</label>
								<TextControl
									value={
										typeof settings[field.id] === 'string'
											? settings[field.id]
											: ''
									}
									placeholder={field.placeholder || ''}
									onChange={(val) => onToggle(field.id, val)}
									__next40pxDefaultSize
								/>
							</div>
						) : null}
					</div>
				))}
			</div>
		</div>
	);
}

const styles = {
	card: {
		background: '#fff',
		borderRadius: 12,
		boxShadow: '0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04)',
		padding: '28px 32px',
	},
	desc: {
		margin: '0 0 24px',
		color: '#50575e',
		fontSize: 14,
		lineHeight: 1.5,
	},
	fields: {
		display: 'flex',
		flexDirection: 'column',
		gap: 4,
	},
	fieldRow: {
		padding: '6px 0',
		borderBottom: '1px solid #f0f0f1',
	},
	textField: {
		display: 'flex',
		flexDirection: 'column',
		gap: 6,
	},
	textLabel: {
		fontSize: 13,
		fontWeight: 500,
		color: '#1d2327',
	},
};
