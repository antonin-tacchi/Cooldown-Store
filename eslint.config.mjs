import globals from 'globals';

export default [
  {
    languageOptions: {
      ecmaVersion: 12,
      sourceType: 'module',
      globals: globals.browser,
    },
    rules: {
      'no-unused-vars': 'warn',
      'no-console': 'off',
      'indent': ['error', 4],
      'quotes': ['error', 'single'],  // Utiliser des guillemets simples
      'semi': ['error', 'always'],
    },
  },
  {
    languageOptions: {
      globals: globals.node,
    },
    files: ['**/*.mjs', '**/*.cjs'],
    rules: {
      'no-unused-vars': 'warn',
      'no-console': 'off',
      'indent': ['error', 2],
      'quotes': ['error', 'single'],  // Utiliser des guillemets simples
      'semi': ['error', 'always'],
    },
  },
];
