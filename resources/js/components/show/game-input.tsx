import { handleSetData } from '@/lib/insertDataUser';
import { inputOrder } from '@/types';
import { BadgeCheck, Loader2, XCircle } from 'lucide-react';
import { Input } from '../ui/input';
import { Label } from '../ui/label';

const InputGame = ({ data, setData, errors, username, loading }: inputOrder) => {
    return (
        <>
            <div className="text-accent-foreground flex items-center gap-4">
                <div className="space-y-3">
                    <Label className="ms-1">ID</Label>
                    <Input
                        id="id"
                        name="id"
                        placeholder="Masukkan User ID"
                        value={data.user_id}
                        onChange={(e) => handleSetData(setData, e, 'user_id')}
                        className="placeholder:text-accent-foreground bg-accent-foreground/10 text-xxs flex-1"
                    />
                </div>
                <div className="space-y-3">
                    <Label className="ms-1">SERVER</Label>
                    <Input
                        id="server"
                        name="server"
                        placeholder="Masukkan Zone ID"
                        value={data.zone_id}
                        onChange={(e) => handleSetData(setData, e, 'zone_id')}
                        className="placeholder:text-accent-foreground text-accent-foreground bg-accent-foreground/10 text-xxs flex-1"
                    />
                </div>

                {errors.user_id && !data.user_id && <p className="error-style">isi user id dengan benar</p>}
                {errors.zone_id && !data.zone_id && <p className="error-style">isi zone id dengan benar</p>}
            </div>
            {loading ? (
                <div className="text-xxs text-accent-foreground w-full rounded-lg border border-gray-300 bg-gray-200 px-2 py-1.5 italic md:text-[11px]">
                    <div className="flex items-center gap-2 text-sm text-blue-600 italic">
                        <Loader2 className="size-4 animate-spin" />
                        <span>Mengecek username...</span>
                    </div>
                </div>
            ) : data.user_id && data.zone_id ? (
                <div
                    className={`text-xxs text-accent-foreground w-full rounded-lg border px-2 py-1.5 italic md:text-[11px] ${
                        username ? 'border-success/40 bg-green-400/50' : 'border-red-400 bg-red-100'
                    }`}
                >
                    {username ? (
                        <div className="flex flex-wrap items-center gap-x-1">
                            <span>Akun kamu adalah</span>
                            <span>{username}</span>
                            <BadgeCheck className="size-3 text-green-600 md:size-4" />
                        </div>
                    ) : (
                        <div className="flex items-center gap-x-1 text-red-600">
                            <XCircle className="size-3 md:size-4" />
                            <span>Username tidak ditemukan.</span>
                        </div>
                    )}
                </div>
            ) : null}

            <p className="text-accent-foreground/70 text-xxs">
                Untuk mengetahui User ID Anda, silahkan klik menu profile di bagian kiri atas pada menu utama game.
            </p>
        </>
    );
};

export default InputGame;
