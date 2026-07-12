import dynamic from "next/dynamic";
import Hero from "@/components/InteriorDesign/Hero";

const OurServices = dynamic(
  () => import("@/components/InteriorDesign/OurServices"),
  {
    loading: () => <div className="py-24 bg-white" />,
  }
);

const Timeline = dynamic(() => import("@/components/InteriorDesign/Timeline"), {
  loading: () => <div className="py-24 bg-gray-50" />,
});

const Showcase = dynamic(() => import("@/components/InteriorDesign/Showcase"), {
  loading: () => <div className="py-24 bg-white" />,
});

const CtaSection = dynamic(
  () => import("@/components/InteriorDesign/CtaSection"),
  {
    loading: () => <div className="py-24 bg-primary/5" />,
  }
);

export default function InteriorDesign() {
  return (
    <>
      <Hero />
      <OurServices />
      <Timeline />
      <Showcase />
      <CtaSection />
    </>
  );
}
