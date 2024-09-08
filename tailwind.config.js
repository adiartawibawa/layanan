import preset from "./vendor/filament/support/tailwind.config.preset";

export default {
    presets: [preset],
    content: [
        "./app/Filament/**/*.php",
        "./resources/views/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
        "./vendor/solution-forest/filament-tree/resources/**/*.blade.php",
    ],
    theme: {
        extend: {
            fontFamily: {
                // sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                caveat: ["Caveat"],
            },
        },
    },
};
