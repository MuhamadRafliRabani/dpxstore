import { configuration } from '@/types';
import { Link, usePage } from '@inertiajs/react';
import { Instagram, Mail, Youtube } from 'lucide-react';
import { memo } from 'react';
import Logo from './ui/logo';

const Footer = memo(() => {
    const { configuration } = usePage<{ configuration: configuration }>().props;

    return (
        <footer className="bg-secondary text-accent-foreground border-t text-sm">
            <div className="container mx-auto grid gap-6 px-4 py-8 md:grid-cols-4">
                {/* Logo dan Deskripsi */}
                <div className="space-y-4 md:col-span-1">
                    <Logo />
                    <p className="text-xs leading-relaxed">
                        {configuration.website} adalah tempat top up games yang aman, murah dan terpercaya. Proses cepat 1-3 Detik. Open 24 jam.
                        Payment terlengkap. Jika ada kendala silahkan klik logo CS pada kanan bawah di website ini.
                    </p>
                    {/* Social Media */}
                    <div className="flex gap-3 text-xl">
                        <a href="#" className="hover:text-white">
                            <Instagram />
                        </a>
                        <a href="#" className="hover:text-white">
                            <svg className="size-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    className="stroke-primary fill-none stroke-2"
                                    d="M12.94,1.61V15.78a2.83,2.83,0,0,1-2.83,2.83h0a2.83,2.83,0,0,1-2.83-2.83h0a2.84,2.84,0,0,1,2.83-2.84h0V9.17h0A6.61,6.61,0,0,0,3.5,15.78h0a6.61,6.61,0,0,0,6.61,6.61h0a6.61,6.61,0,0,0,6.61-6.61V9.17l.2.1a8.08,8.08,0,0,0,3.58.84h0V6.33l-.11,0a4.84,4.84,0,0,1-3.67-4.7H12.94Z"
                                />
                            </svg>
                        </a>
                        <a href="#" className="hover:text-white">
                            <Mail />
                        </a>
                        <a href="#" className="hover:text-white">
                            <Youtube />
                        </a>
                    </div>
                </div>

                {/* Peta Situs */}
                <div>
                    <h4 className="mb-2 text-xs font-semibold">Peta Situs</h4>
                    <ul className="text-accent-foreground/90 space-y-1 text-xs">
                        <li>
                            <Link href={route('home.index')} className="hover:underline">
                                Beranda
                            </Link>
                        </li>
                        <li>
                            <Link href={route('cekPesanan')} className="hover:underline">
                                Cek Transaksi
                            </Link>
                        </li>
                        <li>
                            <Link href={'#'} className="hover:underline">
                                Hubungi Kami
                            </Link>
                        </li>
                        <li>
                            <Link href={'#'} className="hover:underline">
                                Ulasan
                            </Link>
                        </li>
                    </ul>
                </div>

                {/* Dukungan */}
                <div>
                    <h4 className="mb-2 text-xs font-semibold">Dukungan</h4>
                    <ul className="text-accent-foreground/90 space-y-1 text-xs">
                        <li>
                            <a href="#" className="hover:underline">
                                Whatsapp
                            </a>
                        </li>
                        <li>
                            <a href="#" className="hover:underline">
                                Instagram
                            </a>
                        </li>
                        <li>
                            <a href="#" className="hover:underline">
                                Email
                            </a>
                        </li>
                    </ul>
                </div>

                {/* Legalitas */}
                <div>
                    <h4 className="mb-2 text-xs font-semibold">Legalitas</h4>
                    <ul className="text-accent-foreground/90 space-y-1 text-xs">
                        <li>
                            <Link href={route('home.index')} className="hover:underline">
                                Kebijakan Privasi
                            </Link>
                        </li>
                        <li>
                            <Link href={route('home.index')} className="hover:underline">
                                Syarat & Ketentuan
                            </Link>
                        </li>
                    </ul>
                </div>
            </div>

            {/* Bottom Bar */}
            <div className="text-primary border-t py-4 text-center text-xs">&copy; {new Date().getFullYear()} Dpxstore. All rights reserved.</div>
        </footer>
    );
});

export default Footer;
