import fs from 'fs';
import path from 'path';

const manifestPath = path.join('public', 'build', 'manifest.json');
if (!fs.existsSync(manifestPath)) {
    console.error('No se encontró public/build/manifest.json — ejecute vite build primero.');
    process.exit(1);
}

const manifest = JSON.parse(fs.readFileSync(manifestPath, 'utf8'));
const cssEntry = manifest['resources/css/app.css'];
const jsEntry = manifest['resources/js/app.js'];

if (!cssEntry?.file || !jsEntry?.file) {
    console.error('Manifest incompleto.');
    process.exit(1);
}

fs.mkdirSync('public/css', { recursive: true });
fs.mkdirSync('public/js', { recursive: true });

fs.copyFileSync(path.join('public/build', cssEntry.file), path.join('public/css/app.built.css'));
fs.copyFileSync(path.join('public/build', jsEntry.file), path.join('public/js/app.built.js'));

console.log('Assets de respaldo: public/css/app.built.css, public/js/app.built.js');
