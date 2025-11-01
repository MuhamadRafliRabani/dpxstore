import { Gamepad2 } from 'lucide-react';

const NotFound = ({ item, message = 'Mohon kembali lagi nanti atau explore product lain.' }: { item: string; message: string }) => {
    return (
        <div className="text-accent-foreground flex w-full flex-col items-center justify-center">
            <Gamepad2 className="size-10 sm:size-14" />

            <div className="space-y-1 text-center">
                <h2 className="text-sm sm:text-base">{item} tidak ditemukan</h2>
                <span className="text-xs sm:text-sm">{message}</span>
            </div>
        </div>
    );
};

export default NotFound;
