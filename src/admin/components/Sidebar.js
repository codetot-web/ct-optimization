export default function Sidebar({ sections, activeSection, onSelect, iconMap }) {
	return (
		<aside style={styles.sidebar}>
			<div style={styles.logo}>
				<svg width="28" height="28" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
					<rect width="100" height="100" rx="20" fill="#3858e9"/>
					<path d="M30 70V30h18c8 0 14 2 18 6s6 9 6 16-2 12-6 16-10 6-18 6H30zm12-12h4c4 0 7-1 9-3s3-5 3-9-1-7-3-9-5-3-9-3h-4v24z" fill="#fff"/>
				</svg>
				<span style={styles.logoText}>CT</span>
			</div>

			<nav style={styles.nav}>
				{sections.map((section) => {
					const isActive = activeSection === section.id;
					return (
						<button
							key={section.id}
							style={{
								...styles.navItem,
								...(isActive ? styles.navItemActive : {}),
							}}
							onClick={() => onSelect(section.id)}
						>
							<span style={styles.navIcon}>{iconMap[section.icon] || null}</span>
							<span>{section.title}</span>
						</button>
					);
				})}
			</nav>

			<div style={styles.footer}>
				<span style={styles.version}>v1.7.0</span>
			</div>
		</aside>
	);
}

const styles = {
	sidebar: {
		width: 240,
		minWidth: 240,
		background: '#1d2327',
		color: '#f0f0f1',
		display: 'flex',
		flexDirection: 'column',
		padding: 0,
	},
	logo: {
		display: 'flex',
		alignItems: 'center',
		gap: 10,
		padding: '24px 20px 20px',
		borderBottom: '1px solid rgba(255,255,255,0.08)',
	},
	logoText: {
		fontSize: 18,
		fontWeight: 700,
		letterSpacing: '-0.5px',
	},
	nav: {
		flex: 1,
		padding: '12px 8px',
		display: 'flex',
		flexDirection: 'column',
		gap: 2,
	},
	navItem: {
		display: 'flex',
		alignItems: 'center',
		gap: 10,
		padding: '10px 14px',
		border: 'none',
		background: 'transparent',
		color: '#a7aaad',
		fontSize: 13.5,
		fontWeight: 400,
		cursor: 'pointer',
		borderRadius: 8,
		textAlign: 'left',
		width: '100%',
		transition: 'all 0.15s ease',
	},
	navItemActive: {
		background: 'rgba(255,255,255,0.08)',
		color: '#fff',
		fontWeight: 500,
	},
	navIcon: {
		display: 'flex',
		alignItems: 'center',
		width: 20,
		height: 20,
		opacity: 0.7,
	},
	footer: {
		padding: '12px 20px',
		borderTop: '1px solid rgba(255,255,255,0.08)',
		fontSize: 11,
		color: '#646970',
	},
	version: {
		color: '#646970',
	},
};
