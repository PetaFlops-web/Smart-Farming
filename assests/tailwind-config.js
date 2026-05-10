tailwind.config = {
    theme: {
        extend: {
            colors: {
                lime: {
                    400: 'var(--primary)',
                    500: '#84cc16',
                },
                dark: 'var(--dark)',
            },
            fontFamily: {
                display: ['var(--font-display)'],
                body: ['var(--font-body)'],
            },
            spacing: {
                'xs': 'var(--space-xs)',
                'sm': 'var(--space-sm)',
                'md': 'var(--space-md)',
                'lg': 'var(--space-lg)',
                'xl': 'var(--space-xl)',
                '2xl': 'var(--space-2xl)',
            },
            borderRadius: {
                'sm': 'var(--radius-sm)',
                'md': 'var(--radius-md)',
                'lg': 'var(--radius-lg)',
                'xl': 'var(--radius-xl)',
            }
        }
    }
}
