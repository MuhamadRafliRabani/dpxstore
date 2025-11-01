import { handleSetData } from '@/lib/insertDataUser';
import { inputOrder } from '@/types';
import { Loader2 } from 'lucide-react';
import { Input } from '../ui/input';
import { Label } from '../ui/label';

const InputGame = ({ data, setData, errors, username, loading, full_input }: inputOrder) => {
    return (
        <>
            <div className="text-accent-foreground flex items-center gap-4">
                <div className="space-y-3 sm:space-y-5">
                    <Label className="ms-1">ID</Label>
                    <Input
                        id="id"
                        name="id"
                        placeholder="Masukkan User ID"
                        value={data.user_id}
                        onChange={(e) => handleSetData(setData, e, 'user_id')}
                        className="placeholder:text-accent-foreground/40 bg-accent-foreground/10 text-xxs flex-1 md:text-xs md:placeholder:text-xs"
                    />
                </div>

                {full_input == true ? (
                    <div className="space-y-3 sm:space-y-5">
                        <Label className="ms-1">SERVER</Label>
                        <Input
                            id="server"
                            name="server"
                            placeholder="Masukkan Zone ID"
                            value={data.zone_id}
                            onChange={(e) => handleSetData(setData, e, 'zone_id')}
                            className="placeholder:text-accent-foreground/40 text-accent-foreground bg-accent-foreground/10 text-xxs flex-1 md:text-xs md:placeholder:text-xs"
                        />
                    </div>
                ) : (
                    <div className="hidden space-y-3 opacity-0 sm:space-y-5 lg:inline-flex">
                        <Label className="ms-1">SERVER</Label>
                        <Input
                            disabled
                            className="placeholder:text-accent-foreground/40 text-accent-foreground bg-accent-foreground/10 text-xxs flex-1 md:text-xs md:placeholder:text-xs"
                        />
                    </div>
                )}

                {errors.user_id && !data.user_id && <p className="error-style">isi user id dengan benar</p>}
                {errors.zone_id && !data.zone_id && <p className="error-style">isi zone id dengan benar</p>}
            </div>
            {loading ? (
                <div className="text-xxs text-accent-foreground w-full rounded-lg border border-gray-300 bg-gray-200 px-2 py-1.5 italic sm:text-[11px]">
                    <div className="flex items-center gap-2 text-sm text-blue-600 italic">
                        <Loader2 className="size-4 animate-spin" />
                        <span>Mengecek username...</span>
                    </div>
                </div>
            ) : data.user_id && data.zone_id ? //         <div className="flex items-center gap-x-1 text-red-600"> //     ) : ( //         </div> //             <BadgeCheck className="size-3 text-green-600 sm:size-4" /> //             <span>{username}</span> //             <span>Akun kamu adalah</span> //         <div className="flex flex-wrap items-center gap-x-1"> //     {username ? ( // > //     }`} //         username ? 'border-success/40 bg-green-400/50' : 'border-red-400 bg-red-100' //     className={`text-xxs text-accent-foreground w-full rounded-lg border px-2 py-1.5 italic sm:text-[11px] ${ // <div
            //             <XCircle className="size-3 sm:size-4" />
            //             <span>Username tidak ditemukan.</span>
            //         </div>
            //     )}
            // </div>
            null : null}

            {/* <p className="text-accent-foreground/70 text-xxs sm:text-xs">
                Untuk mengetahui User ID Anda, silahkan klik menu profile di bagian kiri atas pada menu utama game.
            </p> */}
        </>
    );
};

export default InputGame;
