module.exports = {
	globDirectory: '.',
	globPatterns: [
		'**/*.{sql,php,html,json,css,png,jpg}'
	],
	swDest: 'sw.js',
	ignoreURLParametersMatching: [
		/^utm_/,
		/^fbclid$/
	]
};