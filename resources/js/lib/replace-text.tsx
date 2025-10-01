export function replaceAppName(text: string, to: string) {
    return text.replace(/\$\{appName\}/g, to);
}
