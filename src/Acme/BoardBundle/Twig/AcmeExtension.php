<?php
namespace Acme\BoardBundle\Twig;

use Symfony\Component\Translation\TranslatorInterface;

class AcmeExtension extends \Twig_Extension
{

    protected $translator;

    /**
     * Constructor method
     *
     * @param IdentityTranslator $translator            
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('human_time_diff', array(
                $this,
                'humanTimeDiff'
            ))
        );
    }

    /**
     * Determines the difference between two timestamps.
     *
     * The difference is returned in a human readable format such as "1 hour",
     * "5 mins", "2 days".
     *
     * @since 1.5.0
     *       
     * @param int $from
     *            Unix timestamp from which the difference begins.
     * @param int $to
     *            Optional. Unix timestamp to end the time difference. Default becomes time() if not set.
     * @return string Human readable time difference.
     */
    function humanTimeDiff($from, $to = '')
    {
        if (empty($to))
            $to = time();
        
        $diff = (int) abs($to - $from);
        
        if ($diff < 3600) {
            $mins = round($diff / 60);
            if ($mins <= 1)
                $mins = 1;
                /* translators: min=minute */
            $since = $this->translator->transChoice('1 min|%num% mins', $mins, array(
                '%num%' => $mins
            ));
        } elseif ($diff < 86400 && $diff >= 3600) {
            $hours = round($diff / 3600);
            if ($hours <= 1)
                $hours = 1;
            $since = $this->translator->transChoice('1 hour|%num% hours', $hours, array(
                '%num%' => $hours
            ));
        } elseif ($diff < 604800 && $diff >= 86400) {
            $days = round($diff / 86400);
            if ($days <= 1)
                $days = 1;
            $since = $this->translator->transChoice('1 day|%num% days', $days, array(
                '%num%' => $days
            ));
        } elseif ($diff < 30 * 86400 && $diff >= 604800) {
            $weeks = round($diff / 604800);
            if ($weeks <= 1)
                $weeks = 1;
            $since = $this->translator->transChoice('1 week|%num% weeks', $weeks, array(
                '%num%' => $weeks
            ));
        } elseif ($diff < 31449600 && $diff >= 30 * 86400) {
            $months = round($diff / (30 * 86400));
            if ($months <= 1)
                $months = 1;
            $since = $this->translator->transChoice('1 month|%num% months', $months, array(
                '%num%' => $months
            ));
        } elseif ($diff >= 31449600) {
            $years = round($diff / 31449600);
            if ($years <= 1)
                $years = 1;
            $since = $this->translator->transChoice('1 year|%num% years', $years, array(
                '%num%' => $years
            ));
        }
        
        return $since;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'acme_extension';
    }
}
