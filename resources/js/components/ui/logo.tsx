import { Link, usePage } from '@inertiajs/react'
import Image from './loading-image'
import { configuration } from '@/types';

const Logo = () => {
  const { configuration } = usePage<{ configuration: configuration }>().props;

  return (
    <Link href={route('home.index')} className="flex items-center w-full md:w-fit">
       <Image src={'/storage/' + configuration.logo_header}  className="h-10 min-w-25" />
    </Link>
  )
}

export default Logo