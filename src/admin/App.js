import { useState, useEffect, useCallback } from '@wordpress/element';
import { Spinner, Notice } from '@wordpress/components';
import { fetchSettings, fetchSchema, saveSettings } from './utils/api';
import Sidebar from './components/Sidebar';
import SettingsSection from './components/SettingsSection';

const ICON_MAP = {
	'admin-site': <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M10 1C5.03 1 1 5.03 1 10s4.03 9 9 9 9-4.03 9-9-4.03-9-9-9zm0 16c-3.86 0-7-3.14-7-7s3.14-7 7-7 7 3.14 7 7-3.14 7-7 7zm1-11H9v2H7v2h2v4h2v-4h2V8h-2V6z"/></svg>,
	'admin-media': <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M4 3h12v2H4V3zm14 3v10c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6h16zM6 9v6l4-3.5L14 15h-1l-3-4-2 2.5V9H6z"/></svg>,
	'admin-generic': <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M17 3H3c-.55 0-1 .45-1 1v12c0 .55.45 1 1 1h14c.55 0 1-.45 1-1V4c0-.55-.45-1-1-1zm-1 12H4V5h12v10z"/></svg>,
	'admin-plugins': <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="currentColor"><path d="M16 2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-1 7H5V7h10v2zm0 4H5v-2h10v2z"/></svg>,
};

export default function App() {
	const [schema, setSchema] = useState([]);
	const [settings, setSettings] = useState({});
	const [activeSection, setActiveSection] = useState('');
	const [loading, setLoading] = useState(true);
	const [saving, setSaving] = useState(false);
	const [notice, setNotice] = useState(null);

	useEffect(() => {
		async function load() {
			try {
				const [s, schemaData] = await Promise.all([fetchSettings(), fetchSchema()]);
				setSettings(s);
				setSchema(schemaData);
				if (schemaData.length > 0) setActiveSection(schemaData[0].id);
			} catch (e) {
				setNotice({ type: 'error', message: 'Failed to load settings.' });
			} finally {
				setLoading(false);
			}
		}
		load();
	}, []);

	const handleToggle = useCallback((key, value) => {
		setSettings((prev) => ({ ...prev, [key]: value }));
	}, []);

	const handleSave = useCallback(async () => {
		setSaving(true);
		setNotice(null);
		try {
			await saveSettings(settings);
			setNotice({ type: 'success', message: 'Settings saved successfully.' });
		} catch (e) {
			setNotice({ type: 'error', message: 'Failed to save settings.' });
		} finally {
			setSaving(false);
			setTimeout(() => setNotice(null), 3000);
		}
	}, [settings]);

	if (loading) {
		return (
			<div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '60vh' }}>
				<Spinner />
			</div>
		);
	}

	const activeData = schema.find((s) => s.id === activeSection);

	return (
		<div style={styles.wrapper}>
			{notice && (
				<div style={{ position: 'fixed', top: 32, right: 20, zIndex: 9999, minWidth: 320 }}>
					<Notice status={notice.type} onRemove={() => setNotice(null)} isDismissible>
						{notice.message}
					</Notice>
				</div>
			)}

			<Sidebar
				sections={schema}
				activeSection={activeSection}
				onSelect={setActiveSection}
				iconMap={ICON_MAP}
			/>

			<main style={styles.main}>
				<div style={styles.header}>
					<h1 style={styles.title}>CT Optimization</h1>
					<button style={styles.saveBtn} onClick={handleSave} disabled={saving}>
						{saving ? 'Saving…' : 'Save Settings'}
					</button>
				</div>

				{activeData && (
					<SettingsSection
						section={activeData}
						settings={settings}
						onToggle={handleToggle}
					/>
				)}
			</main>
		</div>
	);
}

const styles = {
	wrapper: {
		display: 'flex',
		minHeight: 'calc(100vh - 32px)',
		marginLeft: '-20px',
		marginTop: '-10px',
		background: '#f0f0f1',
		fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
	},
	main: {
		flex: 1,
		padding: '32px 40px',
		marginLeft: 0,
	},
	header: {
		display: 'flex',
		alignItems: 'center',
		justifyContent: 'space-between',
		marginBottom: 32,
	},
	title: {
		fontSize: 24,
		fontWeight: 600,
		color: '#1d2327',
		margin: 0,
	},
	saveBtn: {
		padding: '10px 28px',
		background: '#3858e9',
		color: '#fff',
		border: 'none',
		borderRadius: 8,
		fontSize: 14,
		fontWeight: 500,
		cursor: 'pointer',
		transition: 'background 0.2s, opacity 0.2s',
	},
};
