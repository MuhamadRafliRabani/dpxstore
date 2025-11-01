import { handleSetData } from '@/lib/insertDataUser';
import { inputOrder } from '@/types';
import { Input } from '../ui/input';
import { Label } from '../ui/label';

const InputDatapulsa = ({ data, setData, errors }: inputOrder) => {
    return (
        <div className="text-accent-foreground space-y-4">
            <Label className="ms-1">No Handphone</Label>

            <div className="mt-1 flex items-center gap-1">
                <Input
                    readOnly={true}
                    placeholder="+62"
                    className="bg-accent-foreground/10 text-xxs placeholder:text-accent-foreground/40 text-accent w-[50px] text-center opacity-60 md:text-xs md:placeholder:text-xs dark:text-white"
                />
                <Input
                    id="no_handphone"
                    placeholder="0812 3456 7890"
                    inputMode="numeric"
                    pattern="\d*"
                    value={data.no_handphone}
                    onChange={(e) => handleSetData(setData, e, 'no_handphone')}
                    className="placeholder:text-accent-foreground/40 text-accent-foreground bg-accent-foreground/10 text-xxs md:text-xs md:placeholder:text-xs"
                />
            </div>

            {errors.no_handphone && <p className="text-sm text-red-500">Isi no handphone kamu dengan benar</p>}
        </div>
    );
};

export default InputDatapulsa;
