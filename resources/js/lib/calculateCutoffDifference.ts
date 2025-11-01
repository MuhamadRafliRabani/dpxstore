type CutoffResult = {
    diffFromStart: number; // dalam menit
    diffToEnd: number; // dalam menit
    isInCutoff: boolean; // apakah sekarang berada di dalam waktu cutoff
};

export function calculateCutoffDifference(startCutoff: string, endCutoff: string): CutoffResult {
    const now = new Date();

    const start = new Date(now);
    const end = new Date(now);

    const [startH, startM, startS = 0] = startCutoff.split(':').map(Number);
    const [endH, endM, endS = 0] = endCutoff.split(':').map(Number);

    start.setHours(startH, startM, startS, 0);
    end.setHours(endH, endM, endS, 0);

    // Jika end lebih kecil dari start → lewat tengah malam
    if (end < start) {
        end.setDate(end.getDate() + 1);
    }

    // Jika sekarang sebelum start tapi cutoff lewat tengah malam
    if (now < start && end > start) {
        now.setDate(now.getDate() + 1);
    }

    const diffFromStart = Math.floor((now.getTime() - start.getTime()) / 1000 / 60);
    const diffToEnd = Math.floor((end.getTime() - now.getTime()) / 1000 / 60);

    return {
        diffFromStart,
        diffToEnd,
        isInCutoff: diffFromStart >= 0 && diffToEnd >= 0,
    };
}

// // --- contoh penggunaan ---
// const { diffFromStart, diffToEnd, isInCutoff } = calculateCutoffDifference('23:55:00', '01:00:00');

// console.log(`Sudah berjalan: ${diffFromStart} menit`);
// console.log(`Sisa waktu cutoff: ${diffToEnd} menit`);
// console.log(`Status cutoff aktif: ${isInCutoff ? 'YA' : 'TIDAK'}`);
