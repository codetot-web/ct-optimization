/**
 * Fetch settings and schema from the REST API.
 */
const NAMESPACE = '/codetot-optimization/v1';

export async function fetchSettings() {
	const res = await fetch(`${NAMESPACE}/settings`);
	if (!res.ok) throw new Error('Failed to fetch settings');
	const data = await res.json();
	return data.settings;
}

export async function fetchSchema() {
	const res = await fetch(`${NAMESPACE}/settings/schema`);
	if (!res.ok) throw new Error('Failed to fetch schema');
	const data = await res.json();
	return data.schema;
}

export async function saveSettings(settings) {
	const res = await fetch(`${NAMESPACE}/settings`, {
		method: 'POST',
		headers: { 'Content-Type': 'application/json', 'X-WP-Nonce': window.wpApiSettings?.nonce || '' },
		body: JSON.stringify(settings),
	});
	if (!res.ok) throw new Error('Failed to save settings');
	return res.json();
}
