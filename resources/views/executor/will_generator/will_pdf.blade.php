<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Last Will And Testament Of {{ $user_info->legal_name }}</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Crimson+Text:ital,wght@0,400;0,600;1,400&family=Playfair+Display:wght@400;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Crimson Text', Georgia, serif;
            font-size: 13pt;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: #fafafa;
            color: #2c2c2c;
        }

        .page {
            max-width: 210mm;
            margin: 20px auto;
            padding: 40mm 30mm;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            page-break-after: always;
            min-height: 250mm;
        }

        .header {
            text-align: center;
            margin-bottom: 50px;
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 20pt;
            color: #1a1a1a;
            letter-spacing: 0.5px;
        }

        .instructions-page {
            font-size: 12pt;
        }

        .instructions-page h1 {
            font-family: 'Playfair Display', serif;
            font-size: 24pt;
            margin-bottom: 20px;
            color: #1a1a1a;
            text-align: center;
            font-weight: 600;
            line-height: 1.3;
        }

        .instructions-page h2 {
            font-family: 'Playfair Display', serif;
            font-size: 15pt;
            margin-bottom: 12px;
            color: #2c2c2c;
            font-weight: 600;
        }

        .step-number {
            background: linear-gradient(135deg, #2c5aa0, #3d6bb3);
            color: white;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 20px;
            font-size: 14pt;
            box-shadow: 0 2px 8px rgba(44, 90, 160, 0.3);
        }

        .step {
            margin: 35px 0;
            display: flex;
            align-items: flex-start;
        }

        .step-content {
            flex: 1;
        }

        ul {
            margin: 15px 0;
            padding-left: 25px;
        }

        li {
            margin: 8px 0;
        }

        .contact-info {
            background: linear-gradient(135deg, #f8f9fb, #e8f4f8);
            padding: 25px;
            border-radius: 12px;
            margin: 30px 0;
            text-align: center;
            border: 1px solid #e1e8ed;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        }

        .will-title {
            text-align: center;
            font-family: 'Playfair Display', serif;
            font-size: 22pt;
            font-weight: 700;
            margin: 60px 0;
            border-bottom: 3px solid #2c5aa0;
            padding-bottom: 20px;
            color: #1a1a1a;
            letter-spacing: 0.5px;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            margin: 35px 0 20px 0;
            font-size: 16pt;
            color: #2c5aa0;
            border-bottom: 1px solid #e1e8ed;
            padding-bottom: 8px;
        }

        .clause {
            margin: 18px 0;
            text-align: justify;
        }

        .clause-number {
            font-weight: 600;
            margin-right: 8px;
            color: #2c5aa0;
            font-size: 14pt;
        }

        .sub-clause {
            margin: 12px 0 12px 30px;
            text-align: justify;
        }

        .signature-section {
            border: 2px solid #e1e8ed;
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
            background: linear-gradient(135deg, #fafbfc, #f5f7fa);
        }

        .signature-box {
            border: 1px solid #d1d9e0;
            height: 50px;
            margin: 15px 0;
            padding: 8px;
            background: white;
            border-radius: 4px;
        }

        .witness-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin: 30px 0;
        }

        .witness-box {
            border: 2px solid #e1e8ed;
            padding: 20px;
            border-radius: 8px;
            background: linear-gradient(135deg, #fafbfc, #f5f7fa);
        }

        .form-field {
            margin: 12px 0;
            border-bottom: 1px solid #d1d9e0;
            padding-bottom: 4px;
            min-height: 25px;
        }

        .page-footer {
            text-align: right;
            margin-top: 50px;
            font-size: 11pt;
            color: #666;
            font-style: italic;
        }

        .appendix {
            margin-top: 40px;
        }

        .appendix-section {
            margin: 30px 0;
        }

        .message-box {
            background: linear-gradient(135deg, #f0f8ff, #e6f3ff);
            padding: 20px;
            margin: 20px 0;
            border-left: 4px solid #2c5aa0;
            border-radius: 6px;
            font-style: italic;
            box-shadow: 0 2px 8px rgba(44, 90, 160, 0.1);
        }

        strong {
            font-weight: 600;
            color: #1a1a1a;
        }

        p {
            margin: 15px 0;
            text-align: justify;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }

            .page {
                box-shadow: none;
                margin: 0;
                page-break-after: always;
                background: white;
            }
        }
    </style>
</head>

<body>

    <!-- Instructions Page -->
    <div class="page instructions-page">
        <h1>You've nearly finished your will.<br>Here's how to make it legal.</h1>

        <div class="contact-info">
            <strong>Any questions? Email us on hello@executor_hub.com</strong>
        </div>

        <div class="step">
            <div class="step-number">1</div>
            <div class="step-content">
                <h2>Read your will and print it in black and white</h2>
                <p><strong>Order a printed copy for just £6</strong><br>
                    You can order a printed copy of your will at any time, in your Executor Hub account.</p>
                <ul>
                    <li>Read it carefully and make sure you understand it. If anything is unclear, contact us.</li>
                    <li>Staple it securely in the top left corner. You don't need to include this instruction page, but
                        if you do attach it, that's ok – don't try and remove it.</li>
                </ul>
            </div>
        </div>

        <div class="step">
            <div class="step-number">2</div>
            <div class="step-content">
                <h2>Choose your witnesses</h2>
                <p>Choose two witnesses to watch you sign your will and sign it themselves.</p>
                <p><strong>Your witnesses should be:</strong></p>
                <ul>
                    <li>Over 18</li>
                    <li>Someone you know and trust</li>
                    <li>Not a beneficiary in your will</li>
                    <li>Not married to a beneficiary</li>
                </ul>
                <p>If you are elderly, recently bereaved or have a terminal, mental or other serious illness, the law
                    recommends asking a medical practitioner, such as a GP, to act as one of your witnesses. This can
                    help to prove you understand what you are signing.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-number">3</div>
            <div class="step-content">
                <h2>Get together with your witnesses and sign your will</h2>
                <p>Get together with both witnesses. Turn to the 'signatures and witnesses' page. Everyone should use a
                    pen. You sign it first, with both witnesses watching. Each witness should write their details in
                    capital letters and add their signature. If someone makes a mistake, start again if you can, or
                    everyone should write their initials next to the error.</p>
            </div>
        </div>

        <div class="step">
            <div class="step-number">4</div>
            <div class="step-content">
                <h2>Store your will and let your executors know where it is</h2>
                <p>Your will is legal! Do not send your signed will back to us. Store it somewhere safe at home and let
                    your executors know where they can find it. Alternatively, for a small fee, you can store a will
                    with the government's Probate Registry. Search for their details online.</p>
                <p>To invite your friends and family to sort their wills too, visit
                    <strong>executor_hub.com/invite</strong>.
                </p>
            </div>
        </div>
    </div>

    <!-- Title Page -->
    <div class="page">
        <div class="will-title">
            Last Will And Testament Of<br>
            {{ $user_info->legal_name }}
        </div>

        <div style="margin: 120px 0;"></div>

        <div class="contact-info">
            <strong>Has {{ $user_info->legal_name }} died?</strong><br>
            Please contact Executor Hub where we will:<br><br>
            <strong>Call:</strong> 020 3695 1713<br>
            <strong>Email:</strong> bereavement@executor_hub.com<br><br>
            • Help you understand what to do next<br>
            • Provide free guidance on bereavement services, arranging a funeral and dealing with probate
        </div>
    </div>

    <!-- Will Content Page 1 -->
    <div class="page">
        <div class="header">
            Last Will And Testament Of<br>
            {{ $user_info->legal_name }}
        </div>

        <p><strong>I {{ $user_info->legal_name }}</strong> born on <strong>{{ $user_info->date_of_birth }}</strong>
            revoke all earlier Wills made by me so far as they relate to my property in the {{ $user_info->city }} and
            declare this to be my last Will.</p>

        <div class="section-title">Preliminary Declarations</div>

        <div class="clause">
            <span class="clause-number">1</span> I am married to <strong>{{ $user_info->partner_name }}</strong>.
        </div>

        <div class="clause">
            <span class="clause-number">2</span> This Will relates only to my property in the {{ $user_info->city }} and
            does not affect any other property.
        </div>

        <div class="clause">
            <span class="clause-number">3</span> I have the following living children:
            @for ($i = 0; $i < count($user_info->child); $i++)
                @if ($i > 0 && $i == count($user_info->child) - 1)
                and
                @elseif ($i > 0)
                ,
                @endif
                <strong>{{ $user_info->child[$i]->first_name }} {{ $user_info->child[$i]->last_name }}</strong> born on
                <strong>{{ $user_info->child[$i]->date_of_birth }}</strong>
                @endfor
                .
        </div>

        <div class="clause">
            <span class="clause-number">4</span> I wish my funeral to be {{$user_info->funeral[0]->funeral_type}}.
        </div>

        <div class="clause">
            <span class="clause-number">5</span> I have included an Appendix to this Will which is not a testamentary
            document but has been placed with this Will to assist my Trustees in preparing my funeral, finding my
            financial assets and delivering personal messages I have written to my beneficiaries.
        </div>

        <div class="section-title">Executors and Trustees</div>

        <div class="clause">
            <span class="clause-number">6</span> I appoint as my executor and trustee
            @foreach($user_info->executors as $executor)
            <strong>{{ $executor->first_name }} {{ $executor->last_name }} </strong>
            @if (!$loop->last),
            @endif
            @endforeach
            .
        </div>

        <div class="clause">
            <span class="clause-number">7</span> In this will the expression 'my Trustees' means my executor or
            executors and trustee or trustees of this will and any trusts arising under it.
        </div>

        <div class="section-title">Guardians</div>

        <div class="clause">
            <span class="clause-number">8</span>
            <div class="sub-clause">
                @foreach ($user_info->child as $key => $child)
                @php
                $letter = chr(97 + $key); // This converts the loop index (0, 1, 2, etc.) to a, b, c, etc.
                @endphp

                <strong>{{ $letter }}</strong> If <strong>{{ $child->first_name }}</strong> born on <strong>{{ $child->date_of_birth }}</strong> is under 18 and I am the only living parent with parental responsibility at the date of my death I appoint <strong>{{ $user_info->partner_name }}</strong> born on <strong>{{@$user_info->partner[0]->date_of_birth ?? "Date of Birth Not Available"}}</strong> to be their guardian.
                @endforeach
            </div>

        </div>

        <div class="page-footer">
            Page 1 of 6
        </div>
    </div>

    <!-- Will Content Page 2 -->
    <div class="page">
        <div class="header" style="margin-bottom: 30px; text-align: left;">
            Last Will And Testament Of<br>
            {{ $user_info->legal_name }}
        </div>

        <div class="section-title">Pets</div>

        <div class="clause">
            <span class="clause-number">9</span>
            <div class="sub-clause">
                <strong>a</strong> If my pet <strong>
                    @foreach ($user_info->pet as $pet)
                    {{ @$pet->first_name }},
                    @endforeach</strong> is alive and healthy at the date of my death I give
                them to <strong>{{ $user_info->partner_name}}</strong> born on <strong>{{@$user_info->partner[0]->date_of_birth}}</strong>. If they cannot afford
                or refuse to accept the responsibilities of, ownership then I give my Trustees the fullest possible
                discretion to rehome my pet, in a permanent safe and loving home, as soon as possible.
            </div>
        </div>

        <div class="clause">
            <span class="clause-number">10</span> For any other pet that I own at my death then I give my Trustees the
            fullest possible discretion to rehome them, in a permanent safe and loving home, as soon as possible.
        </div>

        <div class="clause">
            <span class="clause-number">11</span> If at the date of my death any pet of mine is suffering or beyond
            reasonable treatment, or where my Trustees are unable to find them a permanent safe and loving home, then I
            give my Trustees the fullest possible discretion to deal with that pet's welfare as they think fit.
        </div>

        <div class="clause">
            <span class="clause-number">12</span> I declare that any expenses incurred by my Trustees in relation to the
            welfare, care, treatment and rehoming of any of my pets will be paid out of my residuary estate.
        </div>

        <div class="section-title">Gifts</div>

        <div class="section-title">Gifts of possessions</div>

        <div class="clause">
            <span class="clause-number">13</span> I give free of inheritance tax the following:
            @foreach ($user_info->gift as $key => $gift)
            @php
            $letter = chr(97 + $key); // Converts index to a, b, c...
            @endphp

            <div class="sub-clause">
                <strong>{{ $letter }}</strong> To
                @if ($gift->inherited_people->isNotEmpty())
                @foreach ($gift->inherited_people as $person)
                <strong>{{ $person->first_name }} {{ $person->last_name }}</strong> born on <strong>{{ $person->date_of_birth }}</strong>@if (!$loop->last)
                ,
                @endif
                @endforeach
                @endif
                my '{{ $gift->gift_name }}'.
            </div>
            @endforeach
        </div>

        <div class="clause">
            <span class="clause-number">14</span> In giving effect to any gift above, my Trustees shall have the final
            and binding decisions as to the identity of any items specifically given and as to the nature and extent of
            any gift.
        </div>

        <div class="clause">
            <span class="clause-number">15</span> My residuary estate shall pay the costs of delivering any gift to a
            beneficiary, vesting any gift in a beneficiary, and the upkeep of any gift until delivery or vesting.
        </div>

        <div class="clause">
            <span class="clause-number">16</span> Any item that fails to pass to a beneficiary will return to my estate
            to be included in my residuary estate.
        </div>


        <div class="page-footer">
            Page 2 of 6
        </div>
    </div>

    <!-- Will Content Page 3 -->
    <div class="page">
        <div class="header" style="margin-bottom: 30px; text-align: left;">
            Last Will And Testament Of<br>
            {{ $user_info->legal_name }}
        </div>

        <div class="section-title">Gifts of money</div>

        <div class="clause">
            <span class="clause-number">17</span> I give free of inheritance tax the following:
            <div class="sub-clause">
                <strong>a</strong> £1000 to <strong>NSPCC (THE NATIONAL SOCIETY FOR THE PREVENTION OF CRUELTY TO
                    CHILDREN)</strong> registered charity number 216401.
            </div>
        </div>

        <div class="clause">
            <span class="clause-number">18</span> Any gift of money that fails to pass to a beneficiary will return to
            my estate to be included in my residuary estate.
        </div>

        <div class="section-title">Residuary estate</div>

        <div class="clause">
            <span class="clause-number">19</span> I give to my Trustees my estate to hold upon trust to use it to pay my
            debts funeral and testamentary expenses, legacies and inheritance tax on all property which vests in them
            and to hold the remainder ('my residuary estate') to divide as follows:

            @forelse ($user_info->beneficiaries as $key => $beneficiary)
            @php
            $letter = chr(97 + $key); // Converts index to a, b, c...
            @endphp

            <div class="sub-clause">
                <strong>{{ $letter }}</strong> {{ number_format($beneficiary->share_percentage, 2) }}% to
                <strong>
                    {{ $beneficiary->getNameAttribute() }}
                    @if (isset($beneficiary->address))
                    of {{ $beneficiary->address }}
                    @endif
                </strong>
                @if (isset($beneficiary->death_backup_plan))
                but if they die before me then to {{ $beneficiary->death_backup_plan }}.
                @endif
            </div>
            @empty
            <p class="text-gray-500">No beneficiaries added yet.</p>
            @endforelse
        </div>

        <div class="section-title">General Provisions</div>

        <div class="clause">
            <span class="clause-number">20</span> Section 33 Wills Act 1837 shall not apply to my will and descendants
            of my beneficiaries shall only take a parent's share where my will specifically provides they should.
        </div>

        <div class="clause">
            <span class="clause-number">21</span> If some shares set out above are exempt from inheritance tax, and
            other shares are chargeable to inheritance tax, then the non-exempt shares must bear that inheritance tax.
        </div>

        <div class="clause">
            <span class="clause-number">22</span> The standard provisions of the Society of Trust and Estate
            Practitioners (3rd Edition) shall apply.
        </div>

        <div class="section-title">Final Declarations</div>

        <div class="clause">
            <span class="clause-number">23</span> I declare that:
            <div style="margin-left: 40px; margin-top: 15px; line-height: 1.8;">
                1. I am over 18;<br>
                2. I am mentally capable of making my own decisions about my will;<br>
                3. I am freely and voluntarily making this will;<br>
                4. I have considered all those persons I might reasonably be expected to provide for by my will; and<br>
                5. I understand this will and approve it as a true reflection of my wishes.
            </div>
        </div>

        <div class="page-footer">
            Page 3 of 6
        </div>
    </div>

    <!-- Signatures Page -->
    <div class="page">
        <div class="header" style="margin-bottom: 30px; text-align: left;">
            Last Will And Testament Of<br>
            {{ $user_info->legal_name }}
        </div>

        <div class="section-title">Signatures and Witnesses</div>

        <div
            style="background: linear-gradient(135deg, #e8f4f8, #f0f8ff); padding: 20px; margin: 25px 0; border-radius: 8px; border-left: 4px solid #2c5aa0;">
            <strong>Guidance:</strong> All three of you must be together. Use a pen. It's ok if the writing isn't fully
            within the boxes.
        </div>

        <div class="clause">
            <span class="clause-number">24</span> This will is signed by me <strong>{{ $user_info->legal_name }}</strong> born on
            <strong>{{ $user_info->date_of_birth }}</strong> in the presence of the two witnesses named below who were each present at the
            same time, and who have each signed this will in my presence.
        </div>

        <div class="signature-section">
            <strong>Signature of {{ $user_info->legal_name }}</strong>
            <div class="signature-box"></div>
            <strong>Date (DD / MM / YYYY)</strong>
            <div class="signature-box"></div>
        </div>

        <div class="clause">
            <span class="clause-number">25</span> This will was signed by <strong>{{ $user_info->legal_name }}</strong> in the
            presence of both of us and then by us in their presence.
        </div>

        <div class="witness-section">
            <div class="witness-box">
                <div><strong>1st witness full name</strong></div>
                <div class="signature-box"></div>
                <div><strong>1st witness occupation</strong></div>
                <div class="signature-box"></div>
                <div><strong>1st witness first line of address</strong></div>
                <div class="signature-box"></div>
                <div><strong>1st witness postcode</strong></div>
                <div class="signature-box"></div>
                <div><strong>1st witness signature</strong></div>
                <div class="signature-box"></div>
            </div>

            <div class="witness-box">
                <div><strong>2nd witness full name</strong></div>
                <div class="signature-box"></div>
                <div><strong>2nd witness occupation</strong></div>
                <div class="signature-box"></div>
                <div><strong>2nd witness first line of address</strong></div>
                <div class="signature-box"></div>
                <div><strong>2nd witness postcode</strong></div>
                <div class="signature-box"></div>
                <div><strong>2nd witness signature</strong></div>
                <div class="signature-box"></div>
            </div>
        </div>

        <div style="margin-top: 50px; font-style: italic; text-align: center; color: #666;">
            The rest of this document does not form part of my will.
        </div>

        <div class="page-footer">
            Page 4 of 6
        </div>
    </div>

    <!-- Appendix Page -->
    <div class="page">
        <div class="header" style="margin-bottom: 30px; text-align: left;">
            Last Will And Testament Of<br>
            {{ $user_info->legal_name }}
        </div>

        <div class="section-title">Appendix</div>

        <p>I have included an Appendix to this Will which is not a testamentary document but has been placed with this
            Will to assist my Trustees.</p>

        <div class="appendix-section">
            <div class="section-title">Funeral</div>
            <p><strong>My additional wishes for my funeral are as follows:</strong></p>
            <div class="message-box">"big party"</div>
        </div>

        <div class="appendix-section">
            <div class="section-title">Financial asset details</div>
            <p>I have included details of my financial assets to help my Trustees to administer my estate.</p>
            <p>This list is accurate at the time of writing, though not necessarily exhaustive, and appropriate efforts
                should still be made to locate additional assets that may not be listed here.</p>

            <ul>
                <li>Property at 9 offington lane, jointly owned, with a mortgage.</li>
                <li>Bank account(s) with hsbc.</li>
                <li>Pension plan with aviva.</li>
                <li>Life insurance policy with legal & general.</li>
                <li>Shares in invesco.</li>
                <li>money under the mattress.</li>
            </ul>
        </div>

        <div class="appendix-section">
            <div class="section-title">About my choices</div>
            <p>I have included an explanation of why I chose to leave certain close family members, partners or people
                who are financially dependent on me out of my will. My Trustees can choose whether it's absolutely
                necessary to share this message or not.</p>
            <div class="message-box">"my brother because we fell out"</div>
        </div>

        <div class="appendix-section">
            <div class="section-title">Messages</div>
            <p>It is my intention that my Trustees deliver the following messages to my intended beneficiaries, either
                electronically or in hard copy. These personal messages should not be shared with anyone other than the
                beneficiaries listed, and as a non testamentary document these messages should be excluded from public
                availability.</p>
        </div>

        <div class="page-footer">
            Page 5 of 6
        </div>
    </div>

    <!-- Final Page -->
    <div class="page">
        <div class="header" style="margin-bottom: 30px; text-align: left;">
            Last Will And Testament Of<br>
            {{ $user_info->legal_name }}
        </div>

        <div class="appendix-section">
            <p><strong>To FIONA JOHNS</strong> - about my gift of 'books at the date of my death':</p>
            <div class="message-box">"i hope you like them"</div>

            <p><strong>To RONNIE JOHNS</strong> - about my gift of 'wedding ring':</p>
            <div class="message-box">"enjoy"</div>

            <p><strong>To {{ $user_info->partner_name}}</strong> - about my gift of 'car aa11 1aa':</p>
            <div class="message-box">"broom broom!"</div>
        </div>

        <div class="appendix-section">
            <div class="section-title">Guidance on the General Provisions</div>

            <p>Your will contains provisions relating to the responsibilities of your executors and trustees. These
                provisions are under the heading General Provisions.</p>

            <p>At Executor Hub we include a set of general provisions, that have been professionally drafted and approved by
                STEP, and are used widely by other professional will writers and solicitors. STEP is the Society of
                Trust and Estate Practitioners, a global professional association that promotes high professional
                standards in this area of law.</p>

            <p>It's important you understand all of your will, including the STEP provisions.</p>

            <p>The will contains a reference to the STEP Standard Provisions (3rd Edition). These provisions give the
                executors a number of technical and routine provisions and powers to help them to administer the estate
                properly. The full text of the STEP Standard Provisions is published on the website of STEP at
                www.step.org/public-policy/step-standard-provisions. We can supply you with a printed copy of the
                provisions.</p>
        </div>

        <div class="page-footer">
            Page 6 of 6
        </div>
    </div>

</body>

</html>